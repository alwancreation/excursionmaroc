<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetSectionProductsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assetTitle',null,array("required"=>true,"label"=>"Product Title"))
            ->add('assetAlt',null,array("required"=>false,"label"=>"Product Subtitle"))
            ->add('assetDescription',TextType::class,array(
                "label"=>"Product Description"
            ))
            ->add('assetLinkTitle',null,array("required"=>false,"label"=>"Product Percent"))
            ->add('assetLink',null,array("required"=>false,"label"=>"Product Link"))
            ->add('assetFile',null,array("required"=>false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Asset'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontbundle_section_asset_products';
    }


}
