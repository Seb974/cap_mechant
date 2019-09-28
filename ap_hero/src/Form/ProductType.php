<?php

namespace App\Form;

use App\Entity\Tva;
use App\Entity\Allergen;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                }
            ])
            ->add('description')
            ->add('allergens', EntityType::class, [
                'class' => Allergen::class,
                'choice_label' => function ($allergen) {
                    return $allergen->getName();
                },
                'multiple' => true,
                'required' => false,
            ])
            ->add('nutritionals')
            ->add('tva', EntityType::class, [
                'class' => Tva::class,
                'choice_label' => function ($tva) {
                    return $tva->getTaux() * 100;
                }
            ])
            ->add('picture', FileType::class, [
                'label' => 'Illustration',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5242880',
                        'mimeTypes' => [
                            "image/png",
                            "image/jpeg",
                            "image/jpg",
                            "image/gif",
                        ],
                        'mimeTypesMessage' => 'Please upload a valid picture',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}