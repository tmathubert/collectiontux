<?php

namespace App\Controller;

use App\Entity\MembreTux;
use App\Form\MembreTux1Type;
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

    #[Route('/{id}', name: 'app_membre_tux_show', methods: ['GET'])]
    public function show(MembreTux $membreTux): Response
    {
        return $this->render('membre_tux/show.html.twig', [
            'membre_tux' => $membreTux,
        ]);
    }
}
