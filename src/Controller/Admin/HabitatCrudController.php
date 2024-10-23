<?php

namespace App\Controller\Admin;

use App\Entity\Habitat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class HabitatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Habitat::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Ne pas afficher l'ID dans le formulaire
            TextField::new('name'), // Champ pour le nom de l'habitat
            TextareaField::new('description'), // Champ pour la description de l'habitat
            ImageField::new('image') // Champ pour uploader une nouvelle image
                ->setLabel('Image (upload)') // Texte du label
                ->setBasePath('uploads/habitats') // Chemin où l'image sera visible
                ->setUploadDir('public/uploads/habitats') // Répertoire où les images sont stockées
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Nom unique pour l'image uploadée
                ->setRequired(false), // Rendre l'image non obligatoire
        ];
    }
}
