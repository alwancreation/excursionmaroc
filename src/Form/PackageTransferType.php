<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\BookingProduct;
use App\Entity\PackageProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageTransferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'label' => 'Transfer Name',
                'required' => true,
                'attr' => [
                    'onchange' => 'App.getTransferPrice(this)'
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where("p.type = 'transfer'")
                        ->orderBy('p.name', 'ASC');
                },
            ])
            ->add('pricePerAdult')
            ->add('pricePerChild')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PackageProduct::class,
        ]);
    }
}
