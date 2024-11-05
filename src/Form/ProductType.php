<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Product Name',
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Product Type',
                'required' => true,
                'choices' => array_flip(Product::$types),
            ])
            ->add('pricePerAdult')
            ->add('pricePerChild')
//            ->add('description')
            ->add('image')
//            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
