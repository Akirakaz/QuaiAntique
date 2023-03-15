<?php

namespace App\Form;

use App\Entity\Opening;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpeningType extends AbstractType
{
    public const MINUTES = [00, 15, 30, 45];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('openMorning', TimeType::class, [
                'label'   => 'Ouverture',
                'hours'   => [12, 13],
                'minutes' => self::MINUTES,
            ])
            ->add('closeMorning', TimeType::class, [
                'label'   => 'Fermeture',
                'hours'   => [14, 15],
                'minutes' => self::MINUTES,
            ])
            ->add('isMorningClosed', CheckboxType::class, [
                'label'    => 'Fermé',
                'required' => false,
            ])
            ->add('openEvening', TimeType::class, [
                'label'   => 'Ouverture',
                'hours'   => [19, 20],
                'minutes' => self::MINUTES,
            ])
            ->add('closeEvening', TimeType::class, [
                'label'   => 'Fermeture',
                'hours'   => [21, 22],
                'minutes' => self::MINUTES,
            ])
            ->add('isEveningClosed', CheckboxType::class, [
                'label'    => 'Fermé',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Opening::class,
        ]);
    }
}
