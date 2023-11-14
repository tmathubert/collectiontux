<?php

namespace App\Controller;

use App\Entity\MembreTux;
use App\Entity\ClasseurTux;
use App\Form\ClasseurTuxType;
use App\Repository\ClasseurTuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/classeur')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ClasseurTuxController extends AbstractController
{
    // Affichage de la liste des classeurs (avec url attaché pour les consulter)
    #[Route('/', name: 'app_classeur_tux_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function listAction(ManagerRegistry $doctrine)
    {
        $entityManager=$doctrine->getManager();
        if ($this->isGranted('ROLE_ADMIN')) {
            $myclasseurs=$entityManager->getRepository(ClasseurTux::class)->findAll();
        }
        else {$user = $this->getUser();
            if($user) {
                    $membre = $user->getMembreTux();
            $myclasseurs = $entityManager->getRepository(ClasseurTux::class)->findBy(
                    [
                          'membreTux' => $membre
                    ]);
        }}
        return $this->render('classeur_tux/index.html.twig', [
            'classeurs' => $myclasseurs,
        ]);
    }
    // Affichage des détails d'un classeur (nom, propriétaire, contenu)
    #[Route('/{id}', name: 'app_classeur_tux_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showAction(ClasseurTux $classeurTux): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()==$classeurTux->getMembretux()->getUser());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à un classeur qui n'est pas le vôtre.");
        }
        return $this->render('classeur_tux/show.html.twig', [
            'classeur' => $classeurTux,
        ]);
    }
    #[Route('/new/{id}', name: 'app_classeur_tux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClasseurTuxRepository $classeurRepository, MembreTux $member,EntityManagerInterface $entityManager): Response
    {
            $classeur = new ClasseurTux();
            $classeur->setMembreTux($member);
            $form = $this->createForm(ClasseurTuxType::class, $classeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeur);
            $entityManager->flush();

            return $this->redirectToRoute('app_classeur_tux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classeur_tux/new.html.twig', [
            'classeur_tux' => $classeur,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_classeur_tux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseurTux $classeurTux, EntityManagerInterface $entityManager): Response
    {   
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()==$classeurTux->getMembretux()->getUser());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à un classeur qui n'est pas le vôtre.");
        }
        $form = $this->createForm(ClasseurTuxType::class, $classeurTux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classeur_tux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classeur_tux/edit.html.twig', [
            'classeur_tux' => $classeurTux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classeur_tux_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseurTux $classeurTux, EntityManagerInterface $entityManager): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()==$classeurTux->getMembretux()->getUser());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à un classeur qui n'est pas le vôtre.");
        }
        if ($this->isCsrfTokenValid('delete'.$classeurTux->getId(), $request->request->get('_token'))) {
            $entityManager->remove($classeurTux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classeur_tux_index', [], Response::HTTP_SEE_OTHER);
    }
}
