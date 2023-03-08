<?php

namespace App\Controller\admin;

use App\Entity\Meal;
use App\Form\MealType;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/meal')]
class MealCrudController extends AbstractController
{
    #[Route('/', name: 'app_admin_meal_index', methods: ['GET'])]
    public function index(MealRepository $mealRepository): Response
    {
        return $this->render('admin/meal/index.html.twig', [
            'meals' => $mealRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_meal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MealRepository $mealRepository): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mealRepository->save($meal, true);

            return $this->redirectToRoute('app_admin_meal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/meal/new.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_meal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meal $meal, MealRepository $mealRepository): Response
    {
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mealRepository->save($meal, true);

            return $this->redirectToRoute('app_admin_meal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_meal_delete', methods: ['POST'])]
    public function delete(Request $request, Meal $meal, MealRepository $mealRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meal->getId(), $request->request->get('_token'))) {
            $mealRepository->remove($meal, true);
        }

        return $this->redirectToRoute('app_admin_meal_index', [], Response::HTTP_SEE_OTHER);
    }
}
