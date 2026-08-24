<?php

namespace App\Controller\Agency;

use App\Entity\Review;
use App\Form\ReviewReplyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/agency/reviews")
 */
class ReviewController extends AbstractAgencyController
{
    /**
     * @Route("/", name="agency_reviews")
     */
    public function indexAction()
    {
        $agency = $this->getCurrentAgency();

        $reviews = $this->getDoctrine()->getRepository(Review::class)
            ->findBy(['agency' => $agency], ['dateCreate' => 'DESC']);

        return $this->render('agency/reviews/index.html.twig', [
            'agency' => $agency,
            'reviews' => $reviews,
        ]);
    }

    /**
     * @Route("/{id}/reply", name="agency_review_reply", requirements={"id"="\d+"})
     */
    public function replyAction(Request $request, Review $review)
    {
        $this->denyAccessUnlessGranted('REVIEW_MANAGE', $review);

        $form = $this->createForm(ReviewReplyType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre réponse a été publiée.');

            return $this->redirectToRoute('agency_reviews');
        }

        return $this->render('agency/reviews/reply.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }
}
