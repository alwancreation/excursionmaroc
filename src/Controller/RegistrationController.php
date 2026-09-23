<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ClientRegistrationType;
use App\Security\AppAuthenticator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function registerAction(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        AppAuthenticator $authenticator
    ) {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        $user = new User();
        $form = $this->createForm(ClientRegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $existing = $em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
            if ($existing) {
                $this->addFlash('error', 'Un compte existe déjà avec cette adresse email.');
                return $this->render('front/security/register.html.twig', ['form' => $form->createView()]);
            }

            $user->setPassword($passwordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $user->setEnabled(true);
            $user->addRole('ROLE_USER');

            $em->persist($user);
            $em->flush();

            $userAuthenticator->authenticateUser($user, $authenticator, $request);

            return $this->redirectToRoute('account_bookings');
        }

        return $this->render('front/security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
