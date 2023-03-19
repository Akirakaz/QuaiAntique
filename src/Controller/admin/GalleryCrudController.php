<?php

namespace App\Controller\admin;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/gallery')]
class GalleryCrudController extends AbstractController
{
    #[Route('/', name: 'app_admin_gallery_index', methods: ['GET'])]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('admin/gallery/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_gallery_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ImageRepository $imageRepository): Response
    {
        $image = new Image();
        $form  = $this->createForm(ImageType::class, $image);

        $form->add('saveAndAdd', SubmitType::class, ['label' => 'Ajouter une autre']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageRepository->save($image, true);

            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'app_admin_gallery_new'
                : 'app_admin_gallery_index';

            $this->addFlash('succès', "L'image a bien été enregistrée.");

            return $this->redirectToRoute($nextAction);
        }

        return $this->render('admin/gallery/new.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_gallery_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Image $image, ImageRepository $imageRepository): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageRepository->save($image, true);

            $this->addFlash('succès', "L'image a bien été mise à jour.");

            return $this->redirectToRoute('app_admin_gallery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/gallery/edit.html.twig', [
            'image' => $image,
            'form'  => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_gallery_delete', methods: ['POST'])]
    public function delete(Request $request, Image $image, ImageRepository $imageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->request->get('_token'))) {
            $imageRepository->remove($image, true);

            $this->addFlash('succès', "L'image a bien été supprimée.");
        }

        return $this->redirectToRoute('app_admin_gallery_index', [], Response::HTTP_SEE_OTHER);
    }
}
