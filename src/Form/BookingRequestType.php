<?php

namespace App\Form;

use App\Entity\ExcursionSchedule;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BookingRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Product $product */
        $product = $options['product'];

        if ($product->getSchedules()->count() > 0) {
            $builder->add('schedule', EntityType::class, [
                'class' => ExcursionSchedule::class,
                'choices' => $product->getSchedules()->filter(function (ExcursionSchedule $s) {
                    return !$s->isFull();
                }),
                'choice_label' => function (ExcursionSchedule $s) {
                    return $s->getDate()->format('d/m/Y') . ($s->getTime() ? ' - ' . $s->getTime() : '') . ' (' . $s->getRemainingCapacity() . ' places)';
                },
                'label' => 'Date',
                'placeholder' => 'Choisissez une date',
                'required' => true,
            ]);
        } else {
            $builder->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date souhaitée',
                'constraints' => [new Assert\NotBlank()],
            ]);
        }

        $builder
            ->add('adults', IntegerType::class, [
                'label' => 'Adultes',
                'data' => 2,
                'constraints' => [new Assert\Range(['min' => 0, 'max' => 50])],
            ])
            ->add('children', IntegerType::class, [
                'label' => 'Enfants',
                'data' => 0,
                'required' => false,
                'constraints' => [new Assert\Range(['min' => 0, 'max' => 50])],
            ])
            ->add('customerName', TextType::class, [
                'label' => 'Nom complet',
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('customerPhone', TextType::class, [
                'label' => 'Téléphone',
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('customerEmail', EmailType::class, [
                'label' => 'Email',
                'constraints' => [new Assert\NotBlank(), new Assert\Email()],
            ])
            ->add('comments', TextareaType::class, [
                'label' => 'Commentaires (optionnel)',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
        $resolver->setRequired('product');
    }

    public function getBlockPrefix()
    {
        return 'booking_request';
    }
}
