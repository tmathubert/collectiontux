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
    // Cette partie commentée sera réimplémentée lorsque les twigs seront prêts !
    /*#[Route('/', name: 'app_classeur_tux', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('classeur_tux/index.html.twig', [
            'controller_name' => 'ClasseurTuxController',
        ]);
    }*/

    // Affichage de la liste des classeurs (avec url attaché pour les consulter)
    #[Route('/', name: 'classeurtux', methods: ['GET'])]
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
    // Affichage des détails d'un classeur (nom, propriétaire, contenu)
    #[Route('/{id}', name: 'classeurtux_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showAction(ClasseurTux $classeur): Response
    {
        $backurl = $this->generateUrl('classeurtux');
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Classeur n° '.$classeur->getId().' details</title>
    </head>
    <body>
        <a href="'.$backurl.'">Retour à la liste des classeurs</a>
        <h2>Détails du classeur :</h2>
        <ul>
        <dl>';
        
        $htmlpage .= '<h3> Nom du classeur  : ' . $classeur->getName() . '</h3>
        <h3>Propriétaire : '.$classeur->getMembreTux()->getPseudo().'</h3>
        <h3>Contenu :</h3>';
        if ($classeur->getCartestux()->isEmpty()) {
            $htmlpage .= '<h2>Ce classeur est vide. :(</h2>';
        }
        foreach($classeur->getCartestux() as $carte) {
            $htmlpage .= '<dd>
            <h4>Carte n°'.$carte->getId().'</h4>
            <li>Type : '. $carte->getType() .'</li>
            <li>Description : '. $carte->getDescription() .'</li>
            <li>Prix : '.$carte->getPrix().'</li>
            <li>Date obtention : '. $carte->getDate()->format('Y-m-d H:i:s').'</li>';
        }
        $htmlpage .= '</dl>';
        $htmlpage .= '</ul></body></html>';
                
        return new Response(
                $htmlpage,
                Response::HTTP_OK,
                array('content-type' => 'text/html')
                );
    }
}