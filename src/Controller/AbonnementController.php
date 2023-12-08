<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Abonnement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\ChoixabonnementType;
use App\Entity\Paiment;
use Psr\Log\LoggerInterface;

class AbonnementController extends AbstractController
{
    private $formFactory;
    private $logger;

    public function __construct(FormFactoryInterface $formFactory, LoggerInterface $logger)
    {
        $this->formFactory = $formFactory;
        $this->logger = $logger;
    }

    #[Route('/sub', name: 'app_sub')]
    public function subscriptionFormAction(Request $request): Response
    {
        $form = $this->formFactory->create(ChoixabonnementType::class);
        $subscriptionTypes = [
            'gold' => 'Description pour l\'abonnement Gold.',
            'silver' => 'Description pour l\'abonnement Silver.',
            'classic' => 'Description pour l\'abonnement Classic.',
        ];
        return $this->render('crud_abonnement\choixabonnements.html.twig', [
            'form' => $form->createView(),
            'subscriptionTypes' => $subscriptionTypes,
        ]);
    }

    #[Route('/handle-subscription-form', name: 'app_handle_subscription_form')]
    public function handleSubscriptionFormAction(Request $request): Response
    {
        $form = $this->formFactory->create(\App\Form\ChoixabonnementType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abonnementType = $form->get('abonnement')->getData();

            // Récupérez l'abonnement correspondant à la sélection
            $entityManager = $this->getDoctrine()->getManager();
            $abonnement = $entityManager->getRepository(Abonnement::class)->findOneBy(['type' => $abonnementType]);

            if (!$abonnement) {
                $this->logger->error('Abonnement non trouvé avec le type : ' . $abonnementType);
                throw new NotFoundHttpException('L\'abonnement n\'existe pas.');
            }

            // Créez une instance de paiement
            $paiement = new Paiment();
            $paiement->setDate(new \DateTime());
            $paiement->setMontant($abonnement->getPrix());

            // Enregistrez le paiement en base de données
            $entityManager->persist($paiement);
            $entityManager->flush();

            // Ajoutez un message flash pour indiquer que le formulaire a été soumis avec succès
            $this->addFlash('success', 'Le formulaire a été soumis avec succès. Passez maintenant au paiement en ligne.');

            // Redirigez l'utilisateur vers le paiement en ligne
            return $this->redirectToRoute('app_paiement_en_ligne', ['id_paiement' => $paiement->getId()]);
        }

        return $this->redirectToRoute('app_paiement_en_ligne', ['id_paiement' => 'DEFAULT_PAIEMENT_ID']);
    }
}
