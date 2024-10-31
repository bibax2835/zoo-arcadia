<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('species'),
            
            // Champ pour afficher l'image existante dans la liste
            ImageField::new('image')
                ->setBasePath('uploads/animals')
                ->onlyOnIndex(),

            // Utilisation de VichImageType pour uploader une nouvelle image
            TextField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setLabel('Upload new image')
                ->onlyOnForms(),

            // Champ pour sélectionner les habitats associés
            AssociationField::new('habitat')
                ->setFormTypeOption('by_reference', false)
                ->setLabel('Habitat(s)')
                ->onlyOnForms(),
        ];
    }
}
