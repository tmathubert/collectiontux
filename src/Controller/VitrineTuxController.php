<?php

namespace App\Controller;

use App\Entity\VitrineTux;
use App\Form\VitrineTuxType;
use App\Repository\VitrineTuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vitrine')]
class VitrineTuxController extends AbstractController
{
    #[Route('/', name: 'app_vitrine_tux_index', methods: ['GET'])]
    public function index(VitrineTuxRepository $vitrineTuxRepository): Response
    {
        return $this->render('vitrine_tux/index.html.twig', [
            'vitrine_tuxes' => $vitrineTuxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vitrine_tux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vitrineTux = new VitrineTux();
        $form = $this->createForm(VitrineTuxType::class, $vitrineTux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vitrineTux);
            $entityManager->flush();

            return $this->redirectToRoute('app_vitrine_tux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vitrine_tux/new.html.twig', [
            'vitrine_tux' => $vitrineTux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vitrine_tux_show', methods: ['GET'])]
    public function show(VitrineTux $vitrineTux): Response
    {
        return $this->render('vitrine_tux/show.html.twig', [
            'vitrine_tux' => $vitrineTux,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vitrine_tux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VitrineTux $vitrineTux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VitrineTuxType::class, $vitrineTux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vitrine_tux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vitrine_tux/edit.html.twig', [
            'vitrine_tux' => $vitrineTux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vitrine_tux_delete', methods: ['POST'])]
    public function delete(Request $request, VitrineTux $vitrineTux, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vitrineTux->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vitrineTux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vitrine_tux_index', [], Response::HTTP_SEE_OTHER);
    }
}
