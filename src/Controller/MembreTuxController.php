<?php

namespace App\Controller;

use App\Entity\MembreTux;
use App\Entity\User;
use App\Repository\MembreTuxRepository;
use App\Form\MembreTuxType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/membre')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class MembreTuxController extends AbstractController
{
    // Consultation de l'ensemble des membres
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'app_membre_tux_index', methods: ['GET'])]
    public function index(MembreTuxRepository $membreTuxRepository): Response
    {
        return $this->render('membre_tux/index.html.twig', [
            'membre_tuxes' => $membreTuxRepository->findAll(),
        ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/edit/{id}', name: 'app_membre_tux_edit', methods: ['GET','POST'])]
    public function edit(Request $request, MembreTux $membreTux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembreTuxType::class, $membreTux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_membre_tux_show', ['id'=>$membreTux->getId()], Response::HTTP_SEE_OTHER);
        }
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()==$membreTux->getUser());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à un profil qui n'est pas le vôtre.");
        }
        return $this->render('membre_tux/edit.html.twig', [
            'membre_tux' => $membreTux,
            'form' => $form,
        ]);
    }
    //Consultation d'un profil
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'app_membre_tux_show', methods: ['GET'])]
    public function show(MembreTux $membreTux): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()==$membreTux->getUser());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à un profil qui n'est pas le vôtre.");
        }
        return $this->render('membre_tux/show.html.twig', [
            'membre_tux' => $membreTux,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
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
