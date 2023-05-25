<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse', ChoiceType::class, [
                "choices" => [
                    'Bizert' => "Bizert",
                    'Tunis' => 'Tunis',
                    'Ariana' => 'Ariana',
                    'Ben Arous' => 'Ben Arous',
                    'Manouba' => 'Manouba',
                    'Nabeul' => 'Nabeul',
                    'Zaghouan' => 'Zaghouan',
                    'Béja' => 'Béja',
                    'Jendouba' => 'Jendouba',
                    'Kef' => 'Kef',
                    'Siliana' => 'Siliana',
                    'Sousse' => 'Sousse',
                    'Monastir' => 'Monastir',
                    'Mahdia' => 'Mahdia',
                    'Sfax' => 'Sfax',
                    'Kairouan' => 'Kairouan',
                    'Kasserine' => 'Kasserine',
                    'Sidi Bouzid' => 'Sidi Bouzid',
                    'Gabès' => 'Gabès',
                    'Mednine' => 'Mednine',
                    'Tataouine' => 'Tataouine',
                    'Gafsa' => 'Gafsa',
                    'Tozeur' => 'Tozeur',
                    'Kebili' => 'Kebili',

                ],
                'label' => false,
                'required' => true,
                'placeholder' => 'Select location',
                'attr' => [
                    'class' => 'form-control col-md-6',
                    'style' => 'margin: 0px  0px 20px 0px;',
                ],

            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => false,
                'placeholder' => 'Select activity',
                'attr' => [
                    'class' => 'form-control col-md-6',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Search',
                'attr' => [
                    'class' => 'col-md-12 btn btn-success',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
