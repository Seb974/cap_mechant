<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType_user extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('zipCode', EntityType::class, [
            //     'class' => City::class,
            //     'choice_label' => function ($zipCode) {
            //         return $zipCode->getZipCode();
            //     }
            // ])
            ->add('name', EntityType::class, [
                'class' => City::class,
                'choice_label' => function ($name) {
                    return $name->getName();
                }
            ])
        ;
        dd($builder);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
