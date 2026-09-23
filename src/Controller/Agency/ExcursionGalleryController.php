<?php

namespace App\Controller\Agency;

use App\Entity\ExcursionImage;
use App\Entity\Product;
use App\Form\ExcursionImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/agency/excursions/{id}/gallery")
 */
class ExcursionGalleryController extends AbstractAgencyController
{
    /**
     * @Route("/", name="agency_excursion_gallery")
     */
    public function indexAction(Request $request, Product $excursion)
    {
        $this->denyAccessUnlessGranted('EXCURSION_MANAGE', $excursion);

        $image = new ExcursionImage();
        $image->setProduct($excursion);

        $form = $this->createForm(ExcursionImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file = $form->get('imageFile')->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move('uploads/excursions', $fileName);
            $image->setPath($fileName);
            $image->setPosition($excursion->getImages()->count());

            if ($image->isMain()) {
                foreach ($excursion->getImages() as $existing) {
                    $existing->setIsMain(false);
                }
            }

            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('agency_excursion_gallery', ['id' => $excursion->getProductId()]);
        }

        return $this->render('agency/excursions/gallery.html.twig', [
            'excursion' => $excursion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{imageId}/delete", name="agency_excursion_gallery_delete", methods={"POST"})
     */
    public function deleteAction(Request $request, Product $excursion, int $imageId)
    {
        $this->denyAccessUnlessGranted('EXCURSION_MANAGE', $excursion);

        if (!$this->isCsrfTokenValid('excursion_image_delete_' . $imageId, $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository(ExcursionImage::class)->find($imageId);

        if ($image && $image->getProduct() === $excursion) {
            $em->remove($image);
            $em->flush();
        }

        return $this->redirectToRoute('agency_excursion_gallery', ['id' => $excursion->getProductId()]);
    }
}
