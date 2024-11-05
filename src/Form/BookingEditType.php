<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('client', null, [
                'required' => true,
            ])
            ->add('clientName', null, [
                'required' => true,
            ])
            ->add('numberOfAdults', null, [
                'required' => true,
            ])
            ->add('numberOfChildren', null, [
                'required' => true,
            ])
            ->add('package', null, [
                'required' => false,
                'disabled' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
