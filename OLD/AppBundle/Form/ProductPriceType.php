<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPriceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price_1')
            ->add('price_2')
            ->add('price_3')
            ->add('price_4')
            ->add('price_5')
            ->add('price_6')
            ->add('price_7')
            ->add('price_8')
            ->add('price_9')
            ->add('price_10')
            ->add('price_11')
            ->add('price_12')
            ->add('price_13')
            ->add('price_14')
            ->add('price_14_plus')
            ->add('child_reduction')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ProductPrice'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product_price';
    }


}
