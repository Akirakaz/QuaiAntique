<?php

namespace App\Controller\admin;

use App\Entity\Formula;
use App\Form\FormulaType;
use App\Repository\FormulaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formula')]
class FormulaController extends AbstractController
{
    #[Route('/', name: 'app_admin_formula_index', methods: ['GET'])]
    public function index(FormulaRepository $formulaRepository): Response
    {
        return $this->render('admin/formula/index.html.twig', [
            'formulas' => $formulaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_formula_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormulaRepository $formulaRepository): Response
    {
        $formula = new Formula();
        $form    = $this->createForm(FormulaType::class, $formula);
        $form->add('saveAndAdd', SubmitType::class, ['label' => 'Ajouter une autre']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formulaRepository->save($formula, true);

            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'app_admin_formula_new'
                : 'app_admin_formula_index';

            $this->addFlash('succès', "La formule a bien été enregistrée.");

            return $this->redirectToRoute($nextAction);
        }

        return $this->render('admin/formula/new.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_formula_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formula $formula, FormulaRepository $formulaRepository): Response
    {
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formulaRepository->save($formula, true);

            $this->addFlash('succès', "La formule a bien été mise à jour.");

            return $this->redirectToRoute('app_admin_formula_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/formula/edit.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_formula_delete', methods: ['POST'])]
    public function delete(Request $request, Formula $formula, FormulaRepository $formulaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formula->getId(), $request->request->get('_token'))) {
            $formulaRepository->remove($formula, true);

            $this->addFlash('succès', "La formule a bien été supprimée.");
        }

        return $this->redirectToRoute('app_admin_formula_index', [], Response::HTTP_SEE_OTHER);
    }
}
