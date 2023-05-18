<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Price', MoneyType::class, [
                'currency' => 'USD',
                'label' => 'Price',
                'attr' => ['readonly' => true],
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['readonly' => true],
            ])
            ->add('reservation', HiddenType::class, [
                'data' => $options['reservation'],
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'reservation' => null,
        ]);
    }
}
