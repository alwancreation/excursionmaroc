<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire d'édition du profil agence, réservé au propriétaire de l'agence.
 * N'expose volontairement pas les champs "valid"/"verified" : ces statuts
 * ne sont modifiables que par un administrateur.
 */
class AgencyProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nom commercial', 'required' => true])
            ->add('legalName', null, ['label' => 'Raison sociale', 'required' => false])
            ->add('shortDescription', TextareaType::class, ['label' => 'Description courte', 'required' => false])
            ->add('longDescription', TextareaType::class, ['label' => 'Description complète', 'required' => false])
            ->add('phone', null, ['label' => 'Téléphone', 'required' => false])
            ->add('whatsapp', null, ['label' => 'WhatsApp', 'required' => false])
            ->add('email', EmailType::class, ['label' => 'Email', 'required' => false])
            ->add('site', UrlType::class, ['label' => 'Site web', 'required' => false])
            ->add('address', null, ['label' => 'Adresse', 'required' => false])
            ->add('city', null, ['label' => 'Ville', 'required' => false])
            ->add('country', null, ['label' => 'Pays', 'required' => false])
            ->add('languagesSpoken', null, ['label' => 'Langues parlées (ex: fr,en,ar)', 'required' => false])
            ->add('yearsExperience', IntegerType::class, ['label' => "Années d'expérience", 'required' => false])
            ->add('facebookUrl', UrlType::class, ['label' => 'Facebook', 'required' => false])
            ->add('instagramUrl', UrlType::class, ['label' => 'Instagram', 'required' => false])
            ->add('assetFile', FileType::class, ['label' => 'Logo', 'required' => false, 'mapped' => true])
            ->add('coverFile', FileType::class, ['label' => 'Photo de couverture', 'required' => false, 'mapped' => true])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Agency',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_agency_profile';
    }
}
