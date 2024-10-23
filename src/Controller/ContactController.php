<?php

// src/Controller/ContactController.php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle entité Contact
        $contact = new Contact();

        // Création du formulaire
        $form = $this->createForm(ContactType::class, $contact);

        // Traitement de la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder le message de contact dans la base de données
            $entityManager->persist($contact);
            $entityManager->flush();

            // Message de confirmation
            $this->addFlash('success', 'Your message has been sent successfully!');

            // Redirection vers la page de contact après soumission
            return $this->redirectToRoute('contact');
        }

        // Rendu du formulaire dans la vue
        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
