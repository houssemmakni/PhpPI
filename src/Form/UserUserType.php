<?php
namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
class UserUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Role 1' => 'User',
                    'Role 2' => 'Admin',
                    // Ajoutez d'autres rôles si nécessaire
                ],
                'multiple' => true, // Permet la sélection de plusieurs rôles
                'expanded' => true, // Affiche les rôles comme des cases à cocher
            ])
            ->add('password', PasswordType::class)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
