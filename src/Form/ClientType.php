<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Client Type',
                'required' => true,
                'choices' => [
                    'Normal' => 'normal',
                    'Fixed' => 'fixed',
                ],
            ])
            ->add('name', null, [
                'label' => 'Client Name',
                'required' => true,
            ])
            ->add('phone', null, [
                'label' => 'Phone Number',
                'required' => true,
            ])
            ->add('email', null, [
                'label' => 'Email Address',
                'required' => true,
            ])
            ->add('address')
            ->add('country')
            ->add('city')
            ->add('website')
            ->add('logoFile')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
