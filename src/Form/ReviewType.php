<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    '5 - Excellent' => 5,
                    '4 - Très bien' => 4,
                    '3 - Correct' => 3,
                    '2 - Décevant' => 2,
                    '1 - Mauvais' => 1,
                ],
                'constraints' => [new NotBlank()],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Votre avis',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10, 'max' => 2000]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Review::class]);
    }

    public function getBlockPrefix()
    {
        return 'review';
    }
}
