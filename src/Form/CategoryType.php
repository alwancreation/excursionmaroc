<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoryName')
            ->add('categorySlug', null, ['required' => false, 'label' => 'Slug (généré automatiquement si vide)'])
            ->add('categoryShortDescription')
            ->add('categoryLongDescription')
            ->add('iconFile', FileType::class, ['required' => false, 'label' => 'Icône'])
            ->add('meta', MetaType::class, ['label' => false])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_category';
    }


}
