<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('pageName')
            ->add('pageTitle')
            ->add('pageSubTitle')
            ->add('pageShortDescription',TextareaType::class,array(
                "attr"=>array(
                    "class"=>"editor",
                    "style"=>"height:120px",
                )))
            ->add('pageLongDescription',TextareaType::class,array(
                "attr"=>array(
                    "class"=>"editor",
                    "style"=>"height:300px",
                )))
            ->add('asset_file',FileType::class,array("required"=>false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Page'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontbundle_page';
    }


}
