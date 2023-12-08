<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Importer le bon type TextType
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;




class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'disabled' =>true,
                'label' =>'Mon adresse email'
            ])
            ->add('firstname',TextType::class,[
                'disabled' => true,
                'label'=>'Mon prenom'
            ])
            ->add('lastname',TextType::class,[
                'disabled' => true,
                'label'=>'Mon nom'
            ])
            ->add('old_password',PasswordType::class,[
                'mapped'=>false,
                'label' => 'Mon mot de passe actuel',
                'attr' =>['placeholder'=> 'Veuillez saisir votre mot de passe ']
            ])
            ->add('new_password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' =>'le mot de passe et confirmation doivent etre identique',
                'label' => 'Mon nouveau  mot de passe',
                'mapped'=>false,
                'required' => true,
                'first_options' => [
                    'label'=>' Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre nouveau mot de passe '
                    ]
                ],
                'second_options' =>[
                    'label' => 'confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre nouveau mot de passe'

                    ]
                ],
            ])
            ->add('submit',SubmitType::class,[
                'label'=>"mettre a jour"
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
