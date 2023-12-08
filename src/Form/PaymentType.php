<?php



namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardHolderName', TextType::class, [
                'label' => 'Nom du titulaire de la carte :',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('cardNumber', TextType::class, [
                'label' => 'Numéro de carte :',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    //new CardScheme(['schemes' => ['VISA', 'MASTERCARD']]), // Ajoutez d'autres types de cartes si nécessaire
                    new Length(['min' => 16, 'max' => 16]),
                ],
            ])
            ->add('expirationDate', DateType::class, [
                'label' => 'Date d\'expiration :',
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'MM/yyyy',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('cvv', IntegerType::class, [
                'label' => 'Code de sécurité (CVV) :',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3, 'max' => 4]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'valider le paiment',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configurez ici les options du formulaire
        ]);
    }
}
