<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ]])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 150,
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez mettre un mot de passe de 8 caratères minimum',
                    ]),
                    
                ]])
            ->add('guests', null, ['label' => 'Convives'])
            ->add('allergies',null,['label' => 'Allergies'])
            ->add('role',null,['label' => 'Role'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
