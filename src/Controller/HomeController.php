<?php
// src/Controller/HomeController.php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ZooRepository;
use App\Repository\HabitatRepository;
use App\Repository\ServiceRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(
        ZooRepository $zooRepo,
        HabitatRepository $habitatRepo,
        ServiceRepository $serviceRepo,
        CommentRepository $commentRepo,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $zoo = $zooRepo->find(1);
        $habitats = $habitatRepo->findAll();
        $services = $serviceRepo->findAll();
        $comments = $commentRepo->findBy([], ['createdAt' => 'DESC'], 4);

        $newComment = new Comment();
        $form = $this->createForm(CommentType::class, $newComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newComment->setCreatedAt(new \DateTime()); // Date d'envoi
            $entityManager->persist($newComment);
            $entityManager->flush();

            // Redirection pour éviter de renvoyer le formulaire en rafraîchissant la page
            return $this->redirectToRoute('home');
        }

        return $this->render('home.html.twig', [
            'zoo' => $zoo,
            'habitats' => $habitats,
            'services' => $services,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }
}
