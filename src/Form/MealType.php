<?php

namespace App\Form;

use App\Entity\Meal;
use App\Entity\MealCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'       => 'Titre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'meal.not_blank',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
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
                        'message' => 'price.invalid',
                    ]),
                ],
            ])
            ->add('category', EntityType::class, [
                'class'       => MealCategory::class,
                'label'       => 'Catégorie',
                'constraints' => [
                    new NotBlank([
                        'message' => 'meal_category.not_blank',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }
}
