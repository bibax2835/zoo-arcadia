<?php

namespace App\Controller;

use App\Entity\Habitat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HabitatController extends AbstractController
{
    #[Route('/habitats', name: 'habitat_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $habitats = $entityManager->getRepository(Habitat::class)->findAll();

        return $this->render('habitat/index.html.twig', [
            'habitats' => $habitats,
        ]);
    }
}
