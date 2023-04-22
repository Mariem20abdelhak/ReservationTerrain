<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Terrain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('surface', NumberType::class)
            ->add('adresse', TextType::class)
            ->add('materiel', TextareaType::class)
            ->add('description', TextareaType::class)
            ->add('price', MoneyType::class)
            ->add('discount', MoneyType::class)
            ->add('image', FileType::class, [
                'data_class' => null,
                'multiple' => true,
                'mapped' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
