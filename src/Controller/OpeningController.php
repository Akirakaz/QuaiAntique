<?php

namespace App\Controller;

use App\Entity\Opening;
use App\Form\OpeningType;
use App\Repository\OpeningRepository;
use App\Service\FilterDay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/opening')]
class OpeningController extends AbstractController
{
    #[Route('/', name: 'app_admin_opening_index', methods: ['GET'])]
    public function index(OpeningRepository $openingDayRepository): Response
    {
        return $this->render('admin/opening/index.html.twig', [
            'opening' => $openingDayRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_opening_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OpeningRepository $openingDayRepository, FilterDay $filterDay): Response
    {
        $openingHour = new Opening();
        $form        = $this->createForm(OpeningType::class, $openingHour);

        $form
            ->add('day', ChoiceType::class, [
                'label'    => 'Jour',
                'choices'  => $filterDay->openingDayFilter(),
                'required' => true,
            ])
            ->add('saveAndAdd', SubmitType::class, ['label' => 'Ajouter un autre']);

        if (empty($filterDay->openingDayFilter())) {
            $form->remove('day');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $openingDayRepository->save($openingHour, true);

            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'app_admin_opening_new'
                : 'app_admin_opening_index';

            return $this->redirectToRoute($nextAction);
        }

        return $this->render('admin/opening/new.html.twig', [
            'opening' => $openingHour,
            'form'    => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_opening_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Opening $openingDay, OpeningRepository $openingDayRepository, FilterDay $filterDay): Response
    {
        $form = $this->createForm(OpeningType::class, $openingDay);

        $form->add('day', ChoiceType::class, [
            'label'    => 'Jour',
            'choices'  => $filterDay::OPENING_DAY,
            'disabled' => true,
        ]);
        $form->add('save', SubmitType::class, ['label' => 'Mettre à jour']);
        $form->remove('saveAndAdd');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $openingDayRepository->save($openingDay, true);

            return $this->redirectToRoute('app_admin_opening_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/opening/edit.html.twig', [
            'opening' => $openingDay,
            'form'    => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_opening_delete', methods: ['POST'])]
    public function delete(Request $request, Opening $openingDay, OpeningRepository $openingDayRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $openingDay->getId(), $request->request->get('_token'))) {
            $openingDayRepository->remove($openingDay, true);
        }

        return $this->redirectToRoute('app_admin_opening_index', [], Response::HTTP_SEE_OTHER);
    }
}
