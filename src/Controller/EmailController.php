<?php
// src/Controller/ConfirmationController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailController extends AbstractController
{
    #[Route('/votre-page-de-validation', name: 'confirmation_page', methods: ['POST'])]

    public function sendConfirmationEmail(Request $request, MailerInterface $mailer): Response
    {
        $email = $request->request->get('email');

        if ($email) {
            // Envoyer un email de confirmation à l'adresse saisie
            $email = (new Email())
                ->from('votre@email.com') // Adresse email de l'expéditeur
                ->to($email) // Adresse email du destinataire
                ->subject('Confirmation de paiement') // Sujet de l'email
                ->text('Votre paiement a été effectué avec succès. Merci !'); // Corps de l'email (texte brut)

            $mailer->send($email);

            return $this->render('confirmation/success.html.twig', [
                'email' => $email,
            ]);
        }

        return $this->redirectToRoute('your_form_route');
    }
}
