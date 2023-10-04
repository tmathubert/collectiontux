<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteTuxController extends AbstractController
{
    #[Route('/carte', name: 'app_carte_tux')]
    public function index(): Response
    {
        return $this->render('carte_tux/index.html.twig', [
            'controller_name' => 'CarteTuxController',
        ]);
    }
}
