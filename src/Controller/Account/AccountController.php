<?php

namespace App\Controller\Account;

use App\Entity\Asset;
use App\Entity\Favorite;
use App\Entity\MarketplaceBooking;
use App\Entity\Product;
use App\Entity\Review;
use App\Form\ClientProfileType;
use App\Form\ReviewType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/account")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("", name="account_profile")
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ClientProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($user->getAssetFile()) {
                $file = $form->get('assetFile')->getData();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move('uploads/avatars', $fileName);

                $asset = new Asset();
                $asset->setAssetBasePath($fileName);
                $em->persist($asset);

                $user->setAsset($asset);
                $user->setAssetFile(null);
            }

            $em->flush();
            $this->addFlash('success', 'Profil mis à jour.');

            return $this->redirectToRoute('account_profile');
        }

        return $this->render('front/account/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bookings", name="account_bookings")
     */
    public function bookingsAction()
    {
        $bookings = $this->getDoctrine()->getRepository(MarketplaceBooking::class)
            ->findForUser($this->getUser());

        $reviewedBookingIds = [];
        if ($bookings) {
            $reviews = $this->getDoctrine()->getRepository(Review::class)
                ->findBy(['user' => $this->getUser()]);
            foreach ($reviews as $review) {
                $reviewedBookingIds[] = $review->getBooking()->getId();
            }
        }

        return $this->render('front/account/bookings.html.twig', [
            'bookings' => $bookings,
            'reviewedBookingIds' => $reviewedBookingIds,
        ]);
    }

    /**
     * @Route("/favorites", name="account_favorites")
     */
    public function favoritesAction()
    {
        $favorites = $this->getDoctrine()->getRepository(Favorite::class)
            ->findForUser($this->getUser());

        return $this->render('front/account/favorites.html.twig', [
            'favorites' => $favorites,
        ]);
    }

    /**
     * @Route("/favorites/{id}/toggle", name="account_favorite_toggle", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function toggleFavoriteAction(Request $request, Product $product)
    {
        if (!$this->isCsrfTokenValid('favorite_toggle_' . $product->getProductId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Favorite::class);
        $existing = $repo->findOneBy(['user' => $this->getUser(), 'product' => $product]);

        if ($existing) {
            $em->remove($existing);
            $this->addFlash('success', 'Retiré des favoris.');
        } else {
            $favorite = new Favorite();
            $favorite->setUser($this->getUser());
            $favorite->setProduct($product);
            $em->persist($favorite);
            $this->addFlash('success', 'Ajouté aux favoris.');
        }
        $em->flush();

        $referer = $request->headers->get('referer');
        if ($referer && parse_url($referer, PHP_URL_HOST) === $request->getHost()) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('account_favorites');
    }

    /**
     * @Route("/bookings/{id}/review", name="account_booking_review", requirements={"id"="\d+"})
     */
    public function reviewAction(Request $request, MarketplaceBooking $booking)
    {
        if ($booking->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('Réservation introuvable.');
        }

        $em = $this->getDoctrine()->getManager();
        $existing = $em->getRepository(Review::class)->findOneBy(['booking' => $booking]);
        if ($existing) {
            $this->addFlash('error', 'Vous avez déjà laissé un avis pour cette réservation.');

            return $this->redirectToRoute('account_bookings');
        }

        $isPast = $booking->getDate() && $booking->getDate() < new \DateTime();
        $eligible = $booking->getStatus() === MarketplaceBooking::STATUS_COMPLETED
            || ($booking->getStatus() === MarketplaceBooking::STATUS_CONFIRMED && $isPast);

        if (!$eligible) {
            $this->addFlash('error', 'Cette réservation n\'est pas encore éligible à un avis.');

            return $this->redirectToRoute('account_bookings');
        }

        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setBooking($booking);
            $review->setUser($this->getUser());
            $review->setProduct($booking->getProduct());
            $review->setAgency($booking->getAgency());

            $em->persist($review);
            $em->flush();

            $this->addFlash('success', 'Merci pour votre avis !');

            return $this->redirectToRoute('account_bookings');
        }

        return $this->render('front/account/review_form.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }
}
