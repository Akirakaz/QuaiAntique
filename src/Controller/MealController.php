<?php

namespace App\Controller;

use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealController extends AbstractController
{
    #[Route('/meal', name: 'app_meal', methods:['GET'])]
    public function index(MealRepository $mealRepository): Response
    {
        return $this->render('public/meal/index.html.twig', [
            'meals' => $mealRepository->findAll(),
        ]);
    }
}
