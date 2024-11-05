<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\BookingProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingTransferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Pickup Date',
            ])
            ->add('hourStart', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Pickup Time',
            ])
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
            ->add('numberOfAdults')
            ->add('numberOfChildren')
            ->add('pricePerAdult')
            ->add('pricePerChild')

            ->add('flightNumber', null, [
                'label' => 'Flight Number',
            ])
            ->add('airport', null, [
                'label' => 'Airport',
            ])
            ->add('flightCompany', null, [
                'label' => 'Flight Company',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookingProduct::class,
        ]);
    }
}
