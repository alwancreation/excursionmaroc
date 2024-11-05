<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\BookingProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingMonumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'label' => 'Monument',
                'required' => true,
                'attr' => [
                    'onchange' => 'App.getMonumentPrice(this)'
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where("p.type = 'monument'")
                        ->orderBy('p.name', 'ASC');
                },
            ])
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
            ])
            ->add('numberOfAdults')
            ->add('numberOfChildren')
            ->add('pricePerAdult')
            ->add('pricePerChild')
//            ->add('totalPrice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookingProduct::class,
        ]);
    }
}
