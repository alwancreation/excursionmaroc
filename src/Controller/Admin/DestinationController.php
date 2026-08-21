<?php

namespace App\Controller\Admin;

use App\Entity\Asset;
use App\Entity\Destination;
use App\Form\DestinationType;
use App\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/destinations")
 */
class DestinationController extends AbstractController
{
    /**
     * @Route("/", name="destination_index", methods={"GET"})
     */
    public function index(): Response
    {
        $destinations = $this->getDoctrine()
            ->getRepository(Destination::class)
            ->findAll();

        return $this->render('admin/destination/index.html.twig', [
            'destinations' => $destinations,
        ]);
    }

    /**
     * @Route("/new", name="destination_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $destination = new Destination();
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUpload($form, $destination);
            $this->ensureSlug($destination);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($destination);
            $entityManager->flush();

            return $this->redirectToRoute('destination_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/destination/new.html.twig', [
            'destination' => $destination,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="destination_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Destination $destination): Response
    {
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUpload($form, $destination);
            $this->ensureSlug($destination);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('destination_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/destination/edit.html.twig', [
            'destination' => $destination,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="destination_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Destination $destination): Response
    {
        if ($this->isCsrfTokenValid('delete' . $destination->getDestinationId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($destination);
            try {
                $entityManager->flush();
            } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
                $this->addFlash('error', 'Cette destination est encore utilisée par des excursions et ne peut pas être supprimée.');
            }
        }

        return $this->redirectToRoute('destination_index', [], Response::HTTP_SEE_OTHER);
    }

    private function handleUpload($form, Destination $destination): void
    {
        if ($destination->getAssetFile()) {
            $file = $form->get('assetFile')->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move('uploads/destinations', $fileName);

            $asset = new Asset();
            $asset->setAssetBasePath($fileName);
            $this->getDoctrine()->getManager()->persist($asset);

            $destination->setMainAsset($asset);
            $destination->setAssetFile(null);
        }
    }

    private function ensureSlug(Destination $destination): void
    {
        if (!$destination->getDestinationSlug()) {
            $destination->setDestinationSlug((new Utils())->slugify($destination->getDestinationName(), ['transliterate' => true]));
        }
    }
}
