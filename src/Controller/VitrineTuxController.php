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
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/vitrine')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class VitrineTuxController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_vitrine_tux_index', methods: ['GET'])]
    public function index(VitrineTuxRepository $vitrineTuxRepository): Response
    {   
        $privateVitrinesTux = array();
        if ($this->isGranted('ROLE_ADMIN')) {
            $privateVitrinesTux = $vitrineTuxRepository->findAll();
        }
        else {$user = $this->getUser();
            if($user) {
                    $membre = $user->getMembreTux();
            $privateVitrinesTux = $vitrineTuxRepository->findBy(
                    [
                          'ispublic' => false,
                          'membretux' => $membre
                    ]);
            }}

        return $this->render('vitrine_tux/index.html.twig', [
            'vitrine_tuxes' => $vitrineTuxRepository->findBy(['ispublic'=>true]),
            'priv_vitrines_tux' => $privateVitrinesTux,
            'user' => $this->getUser(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
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
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'app_vitrine_tux_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showAction(VitrineTux $vitrine): Response
    {
        $hasAccess = false;
        if($this->isGranted('ROLE_ADMIN') || $vitrine->isIspublic()) {
                $hasAccess = true;
        }
        else {
                $user = $this->getUser();
                if( $user ) {
                        $member = $user->getMembreTux();
                        if ( $member &&  ($member == $vitrine->getMembretux()) ) {
                                $hasAccess = true;
                        }
                }
        }
        if(! $hasAccess) {
                throw $this->createAccessDeniedException("You cannot access the requested resource!");
        }
        return $this->render('vitrine_tux/show.html.twig', [
                'vitrine_tux' => $vitrine,
        ]);
    }
    #[IsGranted('ROLE_USER')]
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

    $hasAccess = false;
    if($this->isGranted('ROLE_ADMIN') || $vitrine->isIspublic()) {
            $hasAccess = true;
    }
    else {
            $user = $this->getUser();
              if( $user ) {
                      $member = $user->getMembreTux();
                      if ( $member &&  ($member == $vitrine->getMembreTux()) ) {
                              $hasAccess = true;
                      }
              }
    }
    if(! $hasAccess) {
            throw $this->createAccessDeniedException("You cannot access the requested ressource!");
    }

    return $this->render('vitrine_tux/carte_show.html.twig', [
            'carte_tux' => $carte,
            'vitrine_tux' => $vitrine
      ]);

    }
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edit', name: 'app_vitrine_tux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VitrineTux $vitrineTux, EntityManagerInterface $entityManager): Response
    {   
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()==$vitrineTux->getMembretux()->getUser());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à une vitrine qui n'est pas la vôtre.");
        }
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
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_vitrine_tux_delete', methods: ['POST'])]
    public function delete(Request $request, VitrineTux $vitrineTux, EntityManagerInterface $entityManager): Response
    {   
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()==$vitrineTux->getMembretux()->getUser());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à une vitrine qui n'est pas la vôtre.");
        }
        if ($this->isCsrfTokenValid('delete'.$vitrineTux->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vitrineTux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vitrine_tux_index', [], Response::HTTP_SEE_OTHER);
    }
}
