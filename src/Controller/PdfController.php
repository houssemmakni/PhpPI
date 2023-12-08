<?php

// src/Controller/PdfController.php

namespace App\Controller;

use App\Entity\Abonnement;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf/abonnements", name="generate_pdf")
     */
    public function generatePdf(): Response
    {
        // Récupérez vos données de commande à partir de la base de données ou d'ailleurs
        $AbonnementRepository = $this->getDoctrine()->getRepository(Abonnement::class);
        $commandes = $AbonnementRepository->findAll();


        // Configurez Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        // Créez le contenu HTML du PDF
        $html = $this->renderView('pdf/index.html.twig', [
            'abonnements' => $commandes,
        ]);

        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Définissez la taille du papier (A4 par défaut)
        $dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF
        $dompdf->render();

        // Générez une réponse avec le contenu du PDF
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
