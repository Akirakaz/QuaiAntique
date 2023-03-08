<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealsCrudController extends AbstractController
{
    #[Route('/meals', name: 'app_meals')]
    public function index(): Response
    {
        return $this->render('public/meals/index.html.twig', [
            'controller_name' => 'MealsController',
        ]);
    }
}
