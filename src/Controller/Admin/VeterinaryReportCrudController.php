<?php

namespace App\Controller\Admin;

use App\Entity\VeterinaryReport;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class VeterinaryReportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VeterinaryReport::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Vérifie si l'utilisateur a le rôle de vétérinaire
        if (!$this->isGranted('ROLE_VETERINARIAN')) {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette section.');
        }

        return [
            AssociationField::new('animal'), // Permet de sélectionner un Animal
            DateTimeField::new('date'),
            TextareaField::new('state'),
            TextField::new('food'),
            NumberField::new('foodQuantity'),
        ];
    }
}
