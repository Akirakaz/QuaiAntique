<?php

namespace App\Controller\admin;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_admin_index', methods: ['GET'])]
    public function index(SettingsRepository $settingsRepository): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'totalSeats' => $settingsRepository->findAll()[0],
        ]);
    }

    #[Route('/settings/seats/edit', name: 'app_admin_settings_seats_edit', methods: ['POST'])]
    public function setSeats(Request $request, SettingsRepository $settingsRepository): JsonResponse
    {
        $actualSettings = $settingsRepository->findAll()[0];
        $newSetting     = json_decode($request->getContent(), true);

        if ($newSetting['seats']) {
            $actualSettings->setSeats($newSetting['seats']);
            $settingsRepository->save($actualSettings, true);
            return $this->json($newSetting['seats'], 200);
        }

        return $this->json('Bad Request', 400);
    }
}