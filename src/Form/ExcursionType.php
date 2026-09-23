<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Destination;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire d'édition des informations de base d'une excursion, réservé à
 * l'agence propriétaire. N'expose volontairement pas le champ "status" :
 * le passage en revue (DRAFT -> PENDING_REVIEW) passe par une action dédiée,
 * et seul un administrateur peut publier/rejeter.
 */
class ExcursionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productName', null, ['label' => 'Titre'])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'categoryName',
                'label' => 'Catégorie',
            ])
            ->add('destination', EntityType::class, [
                'class' => Destination::class,
                'choice_label' => 'destinationName',
                'label' => 'Destination',
                'required' => false,
            ])
            ->add('destinationFrom', EntityType::class, [
                'class' => Destination::class,
                'choice_label' => 'destinationName',
                'label' => 'Ville de départ',
                'required' => false,
            ])
            ->add('productShortDescription', TextareaType::class, ['label' => 'Description courte', 'required' => false])
            ->add('productLongDescription', TextareaType::class, ['label' => 'Description complète', 'required' => false])
            ->add('productDuration', null, ['label' => 'Durée (ex: 1 jour, 3 heures)', 'required' => false])
            ->add('productPrice', NumberType::class, ['label' => 'Prix', 'required' => true])
            ->add('minPersons', IntegerType::class, ['label' => 'Capacité minimum', 'required' => false])
            ->add('maxPersons', IntegerType::class, ['label' => 'Capacité maximum', 'required' => false])
            ->add('minAge', IntegerType::class, ['label' => 'Âge minimum', 'required' => false])
            ->add('private', ChoiceType::class, [
                'label' => 'Type',
                'choices' => ['Groupe' => false, 'Privé' => true],
                'required' => false,
            ])
            ->add('transportIncluded', CheckboxType::class, ['label' => 'Transport inclus', 'required' => false])
            ->add('guideIncluded', CheckboxType::class, ['label' => 'Guide inclus', 'required' => false])
            ->add('mealsIncluded', CheckboxType::class, ['label' => 'Repas inclus', 'required' => false])
            ->add('inclusions', TextareaType::class, ['label' => 'Inclus', 'required' => false])
            ->add('exclusions', TextareaType::class, ['label' => 'Non inclus', 'required' => false])
            ->add('meetingPoint', null, ['label' => 'Point de départ', 'required' => false])
            ->add('departureTime', null, ['label' => 'Heure de départ', 'required' => false])
            ->add('returnTime', null, ['label' => 'Heure de retour', 'required' => false])
            ->add('terms', TextareaType::class, ['label' => 'Conditions', 'required' => false])
            ->add('cancellationPolicy', TextareaType::class, ['label' => "Politique d'annulation", 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'excursion';
    }
}
