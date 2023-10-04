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
    #[Route('/', name: 'app_classeur_tux', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('classeur_tux/index.html.twig', [
            'controller_name' => 'ClasseurTuxController',
        ]);
    }
    #[Route('/list', name: 'classeurtux_list', methods: ['GET'])]
    #[Route('/index', name: 'classeurtux_index', methods: ['GET'])]
    public function listAction(ManagerRegistry $doctrine)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des classeurs</title>
    </head>
    <body>
        <h1>Liste des classeurs</h1>
        <p>Voici les classeurs disponibles :</p>
        <ul>';
        
        $entityManager= $doctrine->getManager();
        $classeurs = $entityManager->getRepository(ClasseurTux::class)->findAll();
        foreach($classeurs as $classeur) {
            $url = $this->generateUrl(
                'classeurtux_show',
                ['id' => $classeur->getId()]);
            $htmlpage .= '<li>
            <a href="'. $url .'">'. $classeur->getName() .'</a></li>';
         }
        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }
    #[Route('/{id}', name: 'classeurtux_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showAction(ClasseurTux $classeur): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Classeur n° '.$classeur->getId().' details</title>
    </head>
    <body>
        <h2>Détails du classeur :</h2>
        <ul>
        <dl>';
        
        $htmlpage .= '<dt>Classeur</dt><dd>' . $classeur->getName() . '</dd>';
        $htmlpage .= '</dl>';
        $htmlpage .= '</ul></body></html>';
                
        return new Response(
                $htmlpage,
                Response::HTTP_OK,
                array('content-type' => 'text/html')
                );
    }


}
