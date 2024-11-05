<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sectionTitle')
            ->add('sectionSubTitle')
            ->add('sectionDescription',null,array(
                "attr"=>array(
                    "class"=>"editor",
                    "style"=>"height:200px",
                )))
            ->add('sectionOrder')
            ->add('sectionType',ChoiceType::class,array(
                'choices'  => array(
                    'Text' => null,
                    'Scrollable' => 1,
                    'Gallery' => 2,
                    'Gallery full' => 3,
                    'Products' => 4,
                    'Destinations' => 5,
                    'Themes' => 6,
                ),
            ))
            ->add('assetFile')
            ->add('removeAsset',CheckboxType::class,array("required"=>false))
            ->add('products')
            ->add('destinations')
            ->add('themes')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Section'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_section';
    }


}
