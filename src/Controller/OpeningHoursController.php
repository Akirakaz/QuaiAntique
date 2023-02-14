<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpeningHoursController extends AbstractController
{
    #[Route('/openinghours', name: 'app_opening_hours')]
    public function index(): Response
    {
        return $this->render('opening_hours/index.html.twig', [
            'controller_name' => 'OpeningHoursController',
        ]);
    }
}
