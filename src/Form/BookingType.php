<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookingName')
            ->add('phone')
            ->add('email')
            ->add('guests', ChoiceType::class, [
                'choices' => Booking::GUESTS,
            ])
            ->add('allergies')
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5'  => true,
            ])
            ->add('hour', TimeType::class, [
                'hours'   => Booking::HOURS,
                'minutes' => Booking::MINUTES,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
