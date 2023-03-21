<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookingName', TextType::class, [
                'label'       => 'Nom pour la réservation',
                'attr'        => [
                    'placeholder' => 'Jean Dupont',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'profile.booking_name_not_blank',
                    ]),
                ],
            ])
            ->add('phone', TelType::class, [
                'attr'        => [
                    'placeholder' => '0123456789',
                ],
                'constraints' => [
                    new Regex('/^[0]{1}[0-9]{9}$/', 'profile.incorrect_phone'),
                ],
            ])
            ->add('email', EmailType::class, [
                'required'    => true,
                'attr'        => [
                    'placeholder' => 'jean@dupont.fr',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'email.not_blank',
                    ]),
                    new Email([
                        'message' => 'email.not_valid',
                    ]),
                ],
            ])
            ->add('guests', ChoiceType::class, [
                'label'       => 'Convives',
                'choices'     => User::DEFAULT_GUESTS,
                'constraints' => [
                    new NotBlank([
                        'message' => 'guests.not_blank',
                    ]),
                ],
            ])
            ->add('allergies', TextareaType::class, [
                'required' => false,
                'attr'     => [
                    'placeholder' => 'Indiquez vos allergies alimentaires.',
                    'rows'        => 3,
                ],
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5'  => true,
            ])
            ->add('hour', TimeType::class, [
                'label'   => 'Heure',
                'hours'   => Booking::HOURS,
                'minutes' => Booking::MINUTES,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
