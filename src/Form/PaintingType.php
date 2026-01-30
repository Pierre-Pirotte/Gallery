<?php

namespace App\Form;

use App\Entity\Painting;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\Validator\Constraints as Assert;

class PaintingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'];
        
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du tableau :',
                'attr' => ['minlength' => 5, 'maxlength' => 50]
                ])

            ->add('author', TextType::class, [
                'label' => 'Nom de l\'auteur :',
                'attr' => ['minlength' => 5, 'maxlength' => 50]
                ])

            ->add('description', TextareaType::class, [
                'label' => 'Description :',
                'attr' => ['maxlength' => 10000, 'rows' => 5]
                ])

            ->add('created', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création :',
                'required' => false,
                'empty_data' => null,
                'attr' => ['max'=> (new \DateTime())->format('Y-m-d')]
            ])

            ->add('height', NumberType::class, [
                'label'=> 'Hauteur (cm) :',
                'attr'=> [
                    'placeholder' => 'Ex: 78',
                    'min' => 10,
                    'max' => 1000,
                    'step'=> 0.1 // décimales
                ]
            ])

            ->add('width', NumberType::class, [
                'label'=> 'Largeur (cm) :',
                'attr'=> [
                    'placeholder' => 'Ex: 52',
                    'min' => 10,
                    'max' => 1000,
                    'step'=> 0.1 
                ]
            ])

            ->add('technical', TextType::class, [
                'label'=> 'Technique :',
                'attr' => [
                    'placeholder' => 'Ex: Huile sur toile',
                    'maxlength'=> 100,
                    'minlength'=> 5
                ]
            ])

            ->add('imageFile', VichFileType::class, [
                'required' => !$isEdit,
                'label' => 'Image du tableau :',
                'allow_delete' => false,
                'download_uri' => false,
                'attr' => ['accept' => 'image/jpeg,image/png,image/webp'],
                'help' => $isEdit 
                    ? 'Formats acceptés : JPG, PNG, WEBP (max 5Mo). Laissez vide pour garder l\'image actuelle.' 
                    : 'Formats acceptés : JPG, PNG, WEBP (max 5Mo)',
                'constraints' => !$isEdit ? [
                    new Assert\NotNull(message: 'L\'image du tableau est obligatoire.')
                ] : []
                ])

            ->add('isVisible', CheckboxType::class, [
                'label' => 'Visibilité sur le site :',
                'required' => false, 
                'data' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Painting::class,
            'is_edit' => false, // Par défaut, mode création
        ]);
    }
}
