<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Habitat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType; // Ajoutez cette ligne
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('species')
            ->add('imageFile', FileType::class, [ // Changez 'image' en 'imageFile'
                'label' => 'Image (Fichier JPG, PNG)', // Label pour le champ de fichier
                'required' => false, // Rendre ce champ optionnel si nécessaire
                'mapped' => false, // Ne pas lier ce champ à la propriété image
                'attr' => ['accept' => 'image/*'], // Limite les fichiers acceptés aux images
            ])
            ->add('habitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
