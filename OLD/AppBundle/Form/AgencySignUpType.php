<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgencySignUpType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',null,array("label"=>"Agency name","required"=>true))
            ->add('email', EmailType::class,array("label"=>"Agency email","required"=>true))
            ->add('phone',null,array("label"=>"Agency phone","required"=>true))
            ->add('address',null,array("label"=>"Agency address"))
            ->add('city',null,array("label"=>"Agency city"))
            ->add('site',null,array("label"=>"Agency site"))
            ->add('user_first_name',null,array("required"=>true))
            ->add('user_last_name',null,array("required"=>true))
            ->add('user_email', EmailType::class,array("required"=>true))
            ->add('user_password', PasswordType::class,array("required"=>true))
            ->add('user_password_confirm', PasswordType::class,array("required"=>true))
           ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Agency'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_agency_sign_up';
    }


}
