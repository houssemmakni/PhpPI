<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Added the TextType
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30 ]),
                'attr' => ['placeholder' => 'Merci de saisir votre prénom']
            ])
            ->add('lastName', TextType::class, [
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30 ]),

                'label' => 'Votre nom',
                'attr' => ['placeholder' => 'Merci de saisir votre nom']
            ])
            ->add('email', EmailType::class,[
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 60 ]),
                   

                'label'=>'votre email',
                'attr' =>[
                    'placeholder' => 'Merci de saisir votre adresse email '
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' =>'le mot de passe et confirmation doivent etre identique',
                'label' => 'votre mot de passe',
                'required' => true,
                'first_options' => [
                    'label'=>'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe '
                    ]
                ],
                'second_options' =>[
                    'label' => 'confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre mot de passe'

                    ]
                ],
            ])
           
            ->add('submit',SubmitType::class,[
                'label'=>"s'inscrire"
            ]) 

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}