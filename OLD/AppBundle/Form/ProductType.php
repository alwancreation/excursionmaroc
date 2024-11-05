<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productName')
            ->add('productShortDescription',null,array(
                "attr"=>array(
                    "style"=>"height:120px",
                )))
            ->add('productLongDescription',null,array(
                "attr"=>array(
                    "class"=>"editor",
                    "style"=>"height:300px",
                )))
            ->add('category')
            ->add('destination')
            ->add('destinations')
            ->add('themes')
            ->add('productPrice')


            ->add('private')
            ->add('duration')
            ->add('maxPersons')
            ->add('difficulty',ChoiceType::class,array(
                'choices'  => array(
                    'Easy' => 'Easy',
                    'Medium' => 'Medium',
                    'Hard' => 'Hard',
                ),
            ))

            ->add('productVideoHtml')
            ->add('productMapHtml')
//            ->add('assets')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }


}
