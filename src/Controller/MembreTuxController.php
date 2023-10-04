<?php

namespace App\Controller;

use App\Entity\MembreTux;
use App\Form\MembreTuxType;
use App\Repository\MembreTuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/membre')]
class MembreTuxController extends AbstractController
{
    #[Route('/', name: 'app_membre_tux_index', methods: ['GET'])]
    public function index(MembreTuxRepository $membreTuxRepository): Response
    {
        return $this->render('membre_tux/index.html.twig', [
            'membre_tuxes' => $membreTuxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_membre_tux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membreTux = new MembreTux();
        $form = $this->createForm(MembreTuxType::class, $membreTux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membreTux);
            $entityManager->flush();

            return $this->redirectToRoute('app_membre_tux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('membre_tux/new.html.twig', [
            'membre_tux' => $membreTux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_membre_tux_show', methods: ['GET'])]
    public function show(MembreTux $membreTux): Response
    {
        return $this->render('membre_tux/show.html.twig', [
            'membre_tux' => $membreTux,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_membre_tux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MembreTux $membreTux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembreTuxType::class, $membreTux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_membre_tux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('membre_tux/edit.html.twig', [
            'membre_tux' => $membreTux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_membre_tux_delete', methods: ['POST'])]
    public function delete(Request $request, MembreTux $membreTux, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membreTux->getId(), $request->request->get('_token'))) {
            $entityManager->remove($membreTux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_membre_tux_index', [], Response::HTTP_SEE_OTHER);
    }
}
