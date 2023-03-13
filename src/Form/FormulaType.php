<?php

namespace App\Form;

use App\Entity\Formula;
use App\Entity\Menu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class FormulaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'formula.title.not_blank'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'formula.desc.not_blank'
                    ])
                ]
            ])
            ->add('starter', CheckboxType::class, [
                'label' => 'Entrée',
                'required' => false
            ])
            ->add('main', CheckboxType::class, [
                'label' => 'Plat',
                'required' => false
            ])
            ->add('dessert', CheckboxType::class, [
                'label' => 'Dessert',
                'required' => false
            ])
            ->add('price', MoneyType::class, [
                'label'       => 'Prix',
                'attr'        => [
                    'placeholder' => '0.00',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[0-9]{1,3}([.|,][0-9]{1,2})?$/',
                        'message' => 'price.invalid'
                    ]),
                ],
            ])
            ->add('menu', EntityType::class, [
                'class' => Menu::class,
                'choice_label' => 'title',
                'label' => 'Menu associé',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formula::class,
        ]);
    }
}
