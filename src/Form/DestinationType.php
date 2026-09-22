<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DestinationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('destinationName')
            ->add('destinationCategory', null, ['required' => false])
            ->add('destinationSlug', null, ['required' => false, 'label' => 'Slug (généré automatiquement si vide)'])
            ->add('assetFile', null, ['required' => false, 'label' => 'Image principale'])
            ->add('meta', \App\Form\MetaType::class, ['label' => false])
            // ->add('destinationIcon')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Destination'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_DestinationType';
    }


}
