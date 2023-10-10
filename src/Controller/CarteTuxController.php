<?php

namespace App\Controller;

use App\Entity\CarteTux;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/carte', name: 'cartetux',methods: ['GET'])]
class CarteTuxController extends AbstractController
{
    #[Route('/',name: 'index',methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('carte_tux/index.html.twig', [
            'controller_name' => 'CarteTuxController',
        ]);
    }
    #[Route('/{id}',name: 'show',methods: ['GET'])]
    public function showAction(CarteTux $carte): Response
    {
        return $this->render('carte_tux/show.html.twig',[
            'carte'=>$carte,
        ]);
    }
}
