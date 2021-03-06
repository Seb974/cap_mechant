<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\EditSelfType;

use Doctrine\ORM\EntityManagerInterface;

class UnknownUserType extends AbstractType
{   
    public function getParent()
    {
        return EditSelfType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder ->remove('username')
                 ->remove('password')
                 ->remove('picture');
    }
}