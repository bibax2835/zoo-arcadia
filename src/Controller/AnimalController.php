<?php

namespace App\Controller;

use App\Entity\Animal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Routing\Requirement\Requirement;
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

    #[Route('/animaux/{slug}', name: 'animal_details', requirements: ['slug' => '[a-z0-9-]+'], methods: ['GET'])]

public function animalShow(#[MapEntity(mapping: ['slug' => 'name'])] Animal $animal): Response
{
    return $this->render('animal/details.html.twig', [
        'animal' => $animal,
    ]);
}
}
