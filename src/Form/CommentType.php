<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Painting;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            ->add('rating', null, [
                'label' => 'Votre note de 1 à 10',
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'class' => 'form-control'
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
