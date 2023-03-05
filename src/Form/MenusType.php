<?php

namespace App\Form;

use App\Entity\Menus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('starter', ChoiceType::class, [
                'choices' => [
                    'meal.name' => ''
                ]
            ])
            ->add('main')
            ->add('dessert')
            ->add('description')
            ->add('price')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Entrées' => 'Entrées',
                    'Plats' => 'Plats',
                    'Desserts' => 'Desserts',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menus::class,
        ]);
    }
}
