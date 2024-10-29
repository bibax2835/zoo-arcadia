<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Ne pas afficher l'ID dans le formulaire
            TextField::new('name'), // Champ pour le nom du service
            ImageField::new('image') // Champ pour uploader une nouvelle image
                ->setLabel('Image (upload)') // Texte du label
                ->setBasePath('uploads/services') // Chemin où l'image sera visible
                ->setUploadDir('public/uploads/services') // Répertoire où les images sont stockées
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Nom unique pour l'image uploadée
                ->setRequired(false), // Rendre l'image non obligatoire
            ImageField::new('image') // Champ pour afficher l'image actuelle (optionnel)
                ->setBasePath('uploads/services') // Chemin où l'image est visible
                ->setLabel('Current Image') // Texte du label pour l'image actuelle
                ->onlyOnIndex(), // Afficher uniquement dans l'index, pas lors de l'édition
        ];
    }
}
