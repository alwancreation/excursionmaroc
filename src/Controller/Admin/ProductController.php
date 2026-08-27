<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('admin/product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Excursions marketplace en attente de validation avant publication.
     *
     * @Route("/moderation/pending", name="admin_excursion_pending", methods={"GET"})
     */
    public function pending(): Response
    {
        $excursions = $this->getDoctrine()->getManager()->createQueryBuilder()
            ->select('p')
            ->addSelect('a')
            ->from(Product::class, 'p')
            ->leftJoin('p.agency', 'a')
            ->andWhere('p.status = :status')
            ->setParameter('status', Product::STATUS_PENDING_REVIEW)
            ->orderBy('p.dateCreate', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('admin/product/pending.html.twig', [
            'excursions' => $excursions,
        ]);
    }

    /**
     * @Route("/moderation/{id}/approve", name="admin_excursion_approve", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function approve(Request $request, Product $product, \App\Services\NotificationService $notificationService): Response
    {
        if ($this->isCsrfTokenValid('excursion_approve' . $product->getProductId(), $request->request->get('_token'))
            && $product->getStatus() === Product::STATUS_PENDING_REVIEW
        ) {
            $product->setStatus(Product::STATUS_PUBLISHED);
            $this->getDoctrine()->getManager()->flush();
            $notificationService->notifyAgencyExcursionApproved($product);
            $this->addFlash('success', 'Excursion publiée.');
        }

        return $this->redirectToRoute('admin_excursion_pending');
    }

    /**
     * @Route("/moderation/{id}/reject", name="admin_excursion_reject", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function reject(Request $request, Product $product, \App\Services\NotificationService $notificationService): Response
    {
        if ($this->isCsrfTokenValid('excursion_reject' . $product->getProductId(), $request->request->get('_token'))
            && $product->getStatus() === Product::STATUS_PENDING_REVIEW
        ) {
            $product->setStatus(Product::STATUS_REJECTED);
            $this->getDoctrine()->getManager()->flush();
            $notificationService->notifyAgencyExcursionRejected($product);
            $this->addFlash('success', 'Excursion refusée.');
        }

        return $this->redirectToRoute('admin_excursion_pending');
    }
}
