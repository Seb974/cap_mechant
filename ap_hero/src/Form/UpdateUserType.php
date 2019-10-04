<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Form\CreateUserType;

use Doctrine\ORM\EntityManagerInterface;

class UpdateUserType extends AbstractType
{   
    public function getParent()
    {
        return CreateUserType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder->remove('password');
            
            if ($options['role'] === 'ADMIN') {
                $builder->add('roles', CheckboxType::class, [
                              'label'    => 'Administrator',
                              'data'     => true,
                              'required' => false,
                              'mapped'   => false,
                ]);
            } else {
                $builder->add('roles', CheckboxType::class, [
                              'label'    => 'Administrator',
                              'data'     => false,
                              'required' => false,
                              'mapped'   => false,
                ]);
            }
            $builder->add('isBanned', CheckboxType::class, [
                          'label'    => 'Ban',
                          'required' => false,
                          'mapped'   => true,
            ]);
    }
}