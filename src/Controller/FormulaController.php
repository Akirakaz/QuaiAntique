<?php

namespace App\Controller;

use App\Repository\FormulaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormulaController extends AbstractController
{
    #[Route('/formula', name: 'app_formula', methods: ['GET'])]
    public function index(FormulaRepository $formulaRepository): Response
    {
        return $this->render('public/formula/index.html.twig', [
            'formulas' => $formulaRepository->findAll(),
        ]);
    }
}
