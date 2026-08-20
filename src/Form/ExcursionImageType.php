<?php

namespace App\Form;

use App\Entity\ExcursionImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExcursionImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, ['label' => 'Image', 'required' => true])
            ->add('altText', null, ['label' => 'Texte alternatif (SEO)', 'required' => false])
            ->add('isMain', CheckboxType::class, ['label' => 'Image principale', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ExcursionImage::class]);
    }

    public function getBlockPrefix()
    {
        return 'excursion_image';
    }
}
