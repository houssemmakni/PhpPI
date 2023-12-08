<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class AccountPasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/modifier', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;
        // Retirer la création d'une nouvelle instance User
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_pwd);

                // Utilisation d'une méthode setPassword dans la classe User pour définir le mot de passe
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification="Votre mot de passe a bien ete mise a jour";
            }
        }

        return $this->render('account/password.html.twig', ['form' => $form->createView(),
    'notification'=>$notification]);
    }
}
