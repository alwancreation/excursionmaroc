<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ClientProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userFirstName', TextType::class, ['label' => 'Prénom', 'constraints' => [new Assert\NotBlank()]])
            ->add('userLastName', TextType::class, ['label' => 'Nom', 'constraints' => [new Assert\NotBlank()]])
            ->add('email', EmailType::class, ['label' => 'Email', 'constraints' => [new Assert\NotBlank(), new Assert\Email()]])
            ->add('userPhone', TextType::class, ['label' => 'Téléphone', 'required' => false])
            ->add('userCountry', TextType::class, ['label' => 'Pays', 'required' => false])
            ->add('userLanguage', ChoiceType::class, [
                'label' => 'Langue',
                'choices' => ['Français' => 'fr', 'English' => 'en'],
                'required' => false,
            ])
            ->add('assetFile', FileType::class, ['label' => 'Photo de profil', 'required' => false, 'mapped' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'client_profile';
    }
}
