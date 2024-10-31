<?php
// src/Controller/AnimalController.php

namespace App\Controller;

use App\Entity\Animal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AnimalController extends AbstractController
{
    #[Route('/animaux', name: 'animal_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupération de tous les animaux depuis la base de données
        $animals = $entityManager->getRepository(Animal::class)->findAll();

        return $this->render('animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }
}
