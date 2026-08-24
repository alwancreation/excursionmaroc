<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/reviews")
 */
class ReviewController extends AbstractController
{
    /**
     * @Route("/", name="admin_review_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reviews = $this->getDoctrine()
            ->getRepository(Review::class)
            ->findBy([], ['dateCreate' => 'DESC']);

        return $this->render('admin/review/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    /**
     * @Route("/{id}/publish", name="admin_review_publish", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function publish(Request $request, Review $review): Response
    {
        if ($this->isCsrfTokenValid('review_publish' . $review->getId(), $request->request->get('_token'))) {
            $review->setStatus(Review::STATUS_PUBLISHED);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Avis publié.');
        }

        return $this->redirectToRoute('admin_review_index');
    }

    /**
     * @Route("/{id}/hide", name="admin_review_hide", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function hide(Request $request, Review $review): Response
    {
        if ($this->isCsrfTokenValid('review_hide' . $review->getId(), $request->request->get('_token'))) {
            $review->setStatus(Review::STATUS_HIDDEN);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Avis masqué.');
        }

        return $this->redirectToRoute('admin_review_index');
    }

    /**
     * @Route("/{id}", name="admin_review_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Review $review): Response
    {
        if ($this->isCsrfTokenValid('review_delete' . $review->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($review);
            $entityManager->flush();
            $this->addFlash('success', 'Avis supprimé.');
        }

        return $this->redirectToRoute('admin_review_index', [], Response::HTTP_SEE_OTHER);
    }
}
