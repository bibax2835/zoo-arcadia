<?php

namespace App\Controller;

use App\Repository\ZooRepository;
use App\Repository\HabitatRepository;
use App\Repository\ServiceRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(ZooRepository $zooRepo, HabitatRepository $habitatRepo, ServiceRepository $serviceRepo, CommentRepository $commentRepo): Response
{
    $zoo = $zooRepo->find(1); // ou récupérez selon votre logique
    $habitats = $habitatRepo->findAll();
    $services = $serviceRepo->findAll();
    $comments = $commentRepo->findBy([], ['createdAt' => 'DESC'], 4); // Les 4 derniers avis

    return $this->render('home.html.twig', [
        'zoo' => $zoo,
        'habitats' => $habitats,
        'services' => $services,
        'comments' => $comments,
    ]);
}
}
