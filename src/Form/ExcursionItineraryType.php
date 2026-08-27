<?php

namespace App\Form;

use App\Entity\ExcursionItinerary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExcursionItineraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', null, ['label' => 'Heure (ex: 08:00)', 'required' => false])
            ->add('title', null, ['label' => 'Titre'])
            ->add('description', TextareaType::class, ['label' => 'Description', 'required' => false])
            ->add('duration', null, ['label' => 'Durée', 'required' => false])
            ->add('location', null, ['label' => 'Lieu', 'required' => false])
            ->add('position', IntegerType::class, ['label' => 'Ordre'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ExcursionItinerary::class]);
    }

    public function getBlockPrefix()
    {
        return 'excursion_itinerary';
    }
}
