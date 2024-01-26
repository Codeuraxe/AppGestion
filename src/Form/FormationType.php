<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Ajout de cette ligne
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;
use App\Entity\Playlist;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la Formation',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
            ])
            ->add('publishedAt', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text'
            ])
            ->add('playlist', EntityType::class, [
                'class' => Playlist::class,
                'choice_label' => 'name',
                'multiple' => false, 
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }

    
}