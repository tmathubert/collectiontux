<?php

namespace App\Controller;

use App\Entity\CarteTux;
use App\Entity\ClasseurTux;
use App\Form\CarteTuxType;
use App\Repository\CarteTuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
#[Route('/carte')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class CarteTuxController extends AbstractController
{
    #[Route('/',name: 'app_carte_tux_index',methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('app_classeur_tux_index');
    }
    #[Route('/{id}',name: 'app_carte_tux_show',methods: ['GET'])]
    public function showAction(CarteTux $carte): Response
    {
        return $this->render('carte_tux/show.html.twig',[
            'carte'=>$carte,
        ]);
    }
    #[Route('/new/{id}', name: 'app_carte_tux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarteTuxRepository $carteRepository, ClasseurTux $classeur,EntityManagerInterface $entityManager): Response
    {
            $carte = new CarteTux();
            $carte->setClasseurTux($classeur);
            $form = $this->createForm(CarteTuxType::class, $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carte);
            $entityManager->flush();

            return $this->redirectToRoute('app_carte_tux_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('carte_tux/new.html.twig', [
            'carte_tux' => $carte,
            'classeur' => $classeur,
            'form' => $form,
        ]);
    }
}