<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    #[Route('/gallery', name: 'app_gallery', methods:['GET'])]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('public/gallery/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }
}
