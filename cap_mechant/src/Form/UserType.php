<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code_client', TextType::class, [
                'mapped'          => true,
                'required'        => true,
                'attr' => ['class' => 'form-control form-control-secondary'],
                'constraints' => [
                    new NotBlank( ['message' => 'Un code client est obligatoire'] )
                ]
            ])
            ->add('email', EmailType::class, [
                'mapped'          => true,
                'required'        => true,
                'attr' => ['class' => 'form-control form-control-secondary'],
                'constraints' => [
                    new NotBlank( ['message' => 'Un identifiant est obligatoire'] )
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'attr' => ['class' => 'form-control form-control-secondary'],
                'invalid_message' => 'Les mots de passe saisis sont différents.',
                'options'         => [ 'attr' => [ 'class' => 'password-field']],
                'mapped'          => false,
                'required'        => true,
                'first_options'   => [ 'label' => 'Mot de passe' ],
                'second_options'  => [ 'label' => 'Confirmation'],
                'constraints'     => [
                    new NotBlank([
                        'message' => 'Un mot de passe est obligatoire',
                    ]),
                    new Length([
                        'min'        => 6,
                        'max'        => 20,
                        'minMessage' => "Votre mot de passe doit être composé d'au moins {{ limit }} caractères",
                        'maxMessage' => "Votre mot de passe doit être au maximum de {{ limit }} caractères",
                    ])
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'data' => $options['roles'],
                'mapped' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'roles' => 'ROLE_USER'
        ]);
    }
}
