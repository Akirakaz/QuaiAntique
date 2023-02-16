<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use \Symfony\Component\Validator\Constraints\Image as ImageConstraints;
class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'constraints' => [
                    new ImageConstraints([
                        'maxSize' => '1M',
                        'extensions' => [
                            'jpg',
                            'jpeg',
                            'png',
                            'webp',
                            'avif'
                        ],
                        'extensionsMessage' => 'image.wrong_file_ext',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/avif'
                        ],
                        'mimeTypesMessage' => false
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
