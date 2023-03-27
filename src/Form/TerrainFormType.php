<?php

namespace App\Form;

use App\Entity\Terrain;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TerrainFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('interface', FloatType::class)
            ->add('local', TextType::class)
            ->add('materiel', textareaType::class)
            ->add('descreption', textareaType::class)
            ->add('price', FloatType::class)
            ->add('discount', FloatType::class)
            ->add('image', BlobType::class)
            ->add('category', EntityType::class, [
                'class' => categories::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
