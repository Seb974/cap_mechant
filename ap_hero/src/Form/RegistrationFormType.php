<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\File;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank( ['message' => 'Please enter a pseudo'] ),
                    new Length( [
                        'min'        => 3,
                        'max'        => 16,
                        'minMessage' => 'Your username should be at least {{ limit }} characters',
                        'maxMessage' => 'Your username should be at most {{ limit }} characters',
                    ] )
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [ 
                    new NotBlank( ['message' => 'Please enter an email address'] )
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The entered password are different.',
                'options'         => [ 'attr' => [ 'class' => 'password-field']],
                'mapped'          => false,
                'required'        => false,
                'first_options'   => [ 'label' => 'password' ],
                'second_options'  => [ 'label' => 'confirm pasword'],
                'constraints'     => [ 
                    new Length([
                        'min'        => 6,
                        'max'        => 20,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'maxMessage' => 'Your password should be at most {{ limit }} characters',
                    ])
                ]
            ])
            ->add('picture', FileType::class, [
                'label' => 'Illustration',
                'required' => false,
                'mapped' => false,
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}


// use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
// use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\Validator\Constraints\IsTrue;
// use App\Form\EditSelfType;

// class RegistrationFormType extends AbstractType
// {
//     public function getParent()
//     {
//         return EditSelfType::class;
//     }

//     public function buildForm(FormBuilderInterface $builder, array $options)
//     {
//         $builder->add('agreeTerms', CheckboxType::class, [
//                       'mapped' => false,
//                       'constraints' => [
//                         new IsTrue([
//                             'message' => 'You should agree to our terms.',
//                         ]),
//                     ],
//                 ])
//             ;
//     }
// }



// namespace App\Form;




