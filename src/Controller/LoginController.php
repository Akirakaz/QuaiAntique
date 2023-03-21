<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('public/login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/connexion/success', name: 'app_login_success')]
    public function login_success(): RedirectResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $this->addFlash('info', 'Vous êtes à présent connecté(e).');

        return $this->redirectToRoute('app_profile_index');
    }

    #[Route('/deconnexion', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/deconnexion/success', name: 'app_logout_success', methods: ['GET'])]
    public function logout_success(): RedirectResponse
    {
        $this->addFlash('info', 'Vous êtes à présent déconnecté(e).');

        return $this->redirectToRoute('app_home');
    }
}
