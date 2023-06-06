<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Terrain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control col-2',
                    ],
                ]
            )
            ->add(
                'surface',
                NumberType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
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
                'attr' => [
                    'class' => 'form-control',
                ],

            ])
            ->add(
                'materiel',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add(
                'hours',
                TimeType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add(
                'pause',
                TimeType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add(
                'price',
                MoneyType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add(
                'discount',
                MoneyType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add('image', FileType::class, [
                'data_class' => null,
                'multiple' => true,
                'mapped' => false,
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
