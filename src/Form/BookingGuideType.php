<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\BookingGuide;
use App\Entity\BookingProduct;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingGuideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('guide', EntityType::class, [
                'class' => User::class,
                'label' => 'Guide',
                'required' => true,
                "attr" => array("onchange" => "App.getGuidePrice(this)"),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where("p.userType = 'guide'")
                        ->orderBy('p.user_first_name', 'ASC');
                },
            ])
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('price')
            ->add('duration')
//            ->add('totalPrice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookingGuide::class,
        ]);
    }
}
