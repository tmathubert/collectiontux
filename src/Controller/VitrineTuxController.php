<?php

namespace App\Controller;

use App\Entity\VitrineTux;
use App\Entity\CarteTux;
use App\Entity\MembreTux;
use App\Form\VitrineTuxType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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

    #[Route('/new/{id}', name: 'app_vitrine_tux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VitrineTuxRepository $vitrineRepository, EntityManagerInterface $entityManager, MembreTux $membre): Response
    {
        $vitrineTux = new VitrineTux();
        $vitrineTux->setMembretux($membre);
        $form = $this->createForm(VitrineTuxType::class, $vitrineTux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vitrineTux);
            $entityManager->flush();

            $this->addFlash('message', 'bien ajouté');

            return $this->redirectToRoute('app_vitrine_tux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vitrine_tux/new.html.twig', [
            'vitrine_tux' => $vitrineTux,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_vitrine_tux_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showAction(VitrineTux $vitrine): Response
    {
        return $this->render('vitrine_tux/show.html.twig', [
            'vitrine' => $vitrine,
        ]);
    }

    #[Route('/{vitrine_id}/carte/{carte_id}', methods: ['GET'], name: 'app_vitrine_carte_show')]
    public function carteShow(
        #[MapEntity(id: 'vitrine_id')]
        VitrineTux $vitrine,
        #[MapEntity(id: 'carte_id')]
        CarteTux $carte
    ): Response
    {   
        if(! $vitrine->getCartesTux()->contains($carte)) {
            throw $this->createNotFoundException("Couldn't find such a carte in this vitrine!");
    }

        if(! $vitrine->isIspublic()) {
            throw $this->createAccessDeniedException("You cannot access the requested ressource!");
    }

        return $this->render('vitrine_tux/carte_show.html.twig', [
            'carte' => $carte,
            'vitrine' => $vitrine
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
