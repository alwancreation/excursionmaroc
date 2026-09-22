<?php

namespace App\Form;

use App\Entity\ExcursionSchedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExcursionScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, ['label' => 'Date', 'widget' => 'single_text'])
            ->add('time', null, ['label' => 'Heure (ex: 16:00)', 'required' => false])
            ->add('capacity', IntegerType::class, ['label' => 'Places'])
            ->add('price', NumberType::class, ['label' => 'Prix (optionnel, sinon prix de base)', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ExcursionSchedule::class]);
    }

    public function getBlockPrefix()
    {
        return 'excursion_schedule';
    }
}
