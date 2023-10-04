<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/classeurtux')]
class ClasseurTuxController extends AbstractController
{
    #[Route('/', name: 'app_classeur_tux', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('classeur_tux/index.html.twig', [
            'controller_name' => 'ClasseurTuxController',
        ]);
    }
}
