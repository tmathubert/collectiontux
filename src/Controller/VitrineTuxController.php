<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VitrineTuxController extends AbstractController
{
    #[Route('/vitrine', name: 'app_vitrine_tux',methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('vitrine_tux/index.html.twig', [
            'controller_name' => 'VitrineTuxController',
        ]);
    }
}
