<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('category',null,array("required"=>true))
            ->add('numberPersons',ChoiceType::class,array("required"=>true,
                'choices'  => array(
                    1=>1,
                    2=>2,
                    3=>3,
                    4=>4,
                    5=>5,
                    6=>6,
                    7=>7,
                    8=>8,
                    9=>9,
                    10=>10,
                ),
                ))->
            add('numberOfChildren',ChoiceType::class,array("required"=>true,
                'choices'  => array(
                    1=>1,
                    2=>2,
                    3=>3,
                    4=>4,
                    5=>5,
                    6=>6,
                    7=>7,
                    8=>8,
                    9=>9,
                    10=>10,
                ),
                ))
            //->add('vehicle')
            //->add('theme')
            //->add('destinationFrom')
            //->add('destinationTo')
            ->add('dateStartInput',TextType::class,array("required"=>true, "attr"=>["class"=>"datepicker", "autocomplete"=>"off"]))
            ->add('dateEndInput',TextType::class,array("required"=>true, "attr"=>["class"=>"datepicker", "autocomplete"=>"off"]))

            ->add('firstName',null,array("required"=>true))
            ->add('lastName',null,array("required"=>true))
            //->add('address')
            ->add('phone',null,array("required"=>true))
            ->add('email',null,array("required"=>true))
            ->add('messageContent',TextareaType::class,array("attr"=>["style"=>"height:100px"]))

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Message'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontbundle_message';
    }


}
