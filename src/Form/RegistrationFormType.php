<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookingName', TextType::class, [
                'label'       => 'Nom de réservation',
                'attr'        => ['placeholder' => 'Dupont'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'profile.booking_name_not_blank',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'required'    => true,
                'label'       => 'Email',
                'attr'        => ['placeholder' => 'jean@dupont.fr'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'email.not_blank',
                    ]),
                    new Email([
                        'message' => 'email.not_valid',
                    ]),
                ],
            ])
            ->add('phone', TelType::class, [
                'label'       => 'Téléphone',
                'attr'        => ['placeholder' => '0123456789'],
                'constraints' => [
                    new Regex('/^[0]{1}[0-9]{9}$/', 'profile.incorrect_phone'),
                ],
            ])
            ->add('guests', ChoiceType::class, [
                'label'       => 'Convives',
                'placeholder' => 'Nombre de convives par défaut',
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
            ->add('plainPassword', RepeatedType::class, [
                'mapped'          => false,
                'required'        => true,
                'options'         => ['attr' => ['class' => 'w-full bg-white/60']],
                'type'            => PasswordType::class,
                'invalid_message' => 'password.not_match',
                'first_options'   => ['label' => 'Mot de passe',],
                'second_options'  => ['label' => 'Répétez le mot de passe'],
                'constraints'     => [
                    new NotBlank([
                        'message' => 'password.not_blank',
                    ]),
                    new Length([
                        'min'        => 8,
                        'minMessage' => 'password.char_limit_min',
                        'max'        => 255,
                        'maxMessage' => 'password.char_limit_max',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
