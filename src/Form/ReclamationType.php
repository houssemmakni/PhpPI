<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;


class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('subject', ChoiceType::class, [
            'choices' => [
                'Shop' => 'Shop',
                'Subscription' => 'Subscription',
                'Payment' => 'Payment',
                'Other' => 'Other',
            ],
            'disabled' => 'true',
        ])    
            ->add('description' , TextType::class, [
                'disabled' => true,
            ])
            ->add('userEmail', EmailType::class, [
                'disabled' => true,
            ])
            ->add('Response')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}