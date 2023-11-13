<?php

namespace App\Controller;

use App\Entity\ClasseurTux;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
#[Route('/classeur')]
class ClasseurTuxController extends AbstractController
{
    // Affichage de la liste des classeurs (avec url attaché pour les consulter)
    #[Route('/', name: 'classeurtux', methods: ['GET'])]
    #[Route('/list', name: 'classeurtux_list', methods: ['GET'])]
    #[Route('/index', name: 'classeurtux_index', methods: ['GET'])]
    public function listAction(ManagerRegistry $doctrine)
    {
        $entityManager=$doctrine->getManager();
        $classeurs = $entityManager->getRepository(ClasseurTux::class)->findAll();
        return $this->render('classeur_tux/list.html.twig', [
            'classeurs' => $classeurs,
        ]);
    }
    // Affichage des détails d'un classeur (nom, propriétaire, contenu)
    #[Route('/{id}', name: 'classeurtux_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showAction(ClasseurTux $classeur): Response
    {
        return $this->render('classeur_tux/show.html.twig', [
            'classeur' => $classeur,
        ]);
    }
}