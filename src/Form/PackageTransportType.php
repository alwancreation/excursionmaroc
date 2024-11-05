<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\BookingProduct;
use App\Entity\PackageProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageTransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'label' => 'Transport',
                'required' => true,
                'attr' => [
                    'onchange' => 'App.getTransportPrice(this)'
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where("p.type = 'transport'")
                        ->orderBy('p.name', 'ASC');
                },
            ])
            ->add('pricePerAdult')
            ->add('pricePerChild')
//            ->add('totalPrice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PackageProduct::class,
        ]);
    }
}
