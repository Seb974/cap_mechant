<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Tva;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('picture')
            ->add('nutritionals')
            ->add('allergens')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                }
            ])
            ->add('tva', EntityType::class, [
                'class' => Tva::class,
                'choice_label' => function ($tva) {
                    return $tva->getTaux() * 100;
                }
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
