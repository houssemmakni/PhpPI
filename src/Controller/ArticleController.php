<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\BuilderInterface; 
use Endroid\QrCode\Writer\Result\PngResult;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
#[Route('/article')]
class ArticleController extends AbstractController
{
    private $qrCodeBuilder;

    public function __construct(BuilderInterface $qrCodeBuilder)
    {
        $this->qrCodeBuilder = $qrCodeBuilder;
    }

    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        foreach ($articles as $article) {
            // Check if $this->qrCodeBuilder is not null
            if ($this->qrCodeBuilder !== null) {
                // Customize the QR code data
                $qrCodeResult = $this->qrCodeBuilder
                    ->data($article->getTitreArticle())
                    ->build();

                // Convert the QR code result to a string representation
                $qrCodeString = $this->convertQrCodeResultToString($qrCodeResult);

                // Add the QR code string to the article entity
                $article->setQrCode($qrCodeString);
            }
        }

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    private function convertQrCodeResultToString(PngResult $qrCodeResult): string
    {
        // Convert the result to a string (e.g., base64 encode the image)
        // Adjust this logic based on how you want to represent the QR code data
        return 'data:image/png;base64,' . base64_encode($qrCodeResult->getString());
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('article_images_directory'),
                    $newFilename
                );
                $article->setImage($newFilename);
            }

            $entityManager->persist($article);
            $entityManager->flush();
            
            $email=(new Email())
            ->from('ayoub.marzougui@esprit.tn')
            ->to('ayoubmarzougui03@gmail.com')
            ->text("test email");
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('article_images_directory'),
                    $newFilename
                );
                $article->setImage($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
    // Display articles for clients
public function indexClient(ArticleRepository $articleRepository): Response
{
    $articles = $articleRepository->findAll();
    return $this->render('client/index_client.html.twig', ['articles' => $articles]);
}

// Display command form
public function showCommandForm(Article $article): Response
{
    return $this->render('command/form.html.twig', ['article' => $article]);
}


public function processCommandForm(Request $request, EntityManagerInterface $entityManager): Response
{
   
    $articleId = $request->request->get('article_id');
    $titreArticle = $request->request->get('titre_article');
    $quantity = $request->request->get('quantity');
    $address = $request->request->get('address');
    $name = $request->request->get('name');
    $phone = $request->request->get('phone');
    $email = $request->request->get('email'); // Add this line to get the email

    // Assuming you have a 'prix' field in the Article entity, you can get the price like this
    $price = $request->request->get('prix');
    
    // Calculate the total price
    $totalPrice = $quantity * $price;

    // Create a new Commande entity and set its properties
    $commande = new Commande();
    $dateCommande = new \DateTime();
    $commande->setArticle($entityManager->getReference(Article::class, $articleId));
    $commande->setnomarticle($titreArticle);
    $commande->setidarticle($articleId);
    $commande->setNombre($quantity);
    $commande->setAddresseCommande($address);
    $commande->setNomPrenomCommande($name);
    $commande->setTelCommande($phone);
    $commande->setEmail($email); // Set the email property
    $commande->setTotalPrice($totalPrice); // Set the total price property
    
    
    $commande->setArticle($entityManager->getReference(Article::class, $articleId));
    // ... other setters
    $commande->setDateCommande($dateCommande);
    // Persist and flush the entity
    $entityManager->persist($commande);
    $entityManager->flush();

    // You might want to redirect to a confirmation page or do something else
    return $this->redirectToRoute('app_article_index_client', [], Response::HTTP_SEE_OTHER);
}

}



