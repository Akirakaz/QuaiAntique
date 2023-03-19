<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menus', name: 'app_menus', methods: ['GET'])]
    public function index(MenuRepository $menuRepository): Response
    {
        return $this->render('public/menu/index.html.twig', [
            'menus' => $menuRepository->findAll(),
        ]);
    }
}
