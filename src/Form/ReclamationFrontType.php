<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
class ReclamationFrontType extends AbstractType
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
            ]
        ])    
            ->add('description')
            ->add('userEmail', EmailType::class, [
                'constraints' => [
                    new Email([
                        'message' => 'The email "{{ value }}" is not a valid email.',
                    ]),
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
