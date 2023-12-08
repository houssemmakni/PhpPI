<?php

namespace App\Controller;
use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CoursRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminhController extends AbstractController
{
    #[Route('/adminh', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('adminh/index.html.twig', [
            'controller_name' => 'AdminhController',
        ]);
    }
       

       #[Route('/stats', name:'stats')]
       public function statistiques(CategoriesRepository $categRepo,  CoursRepository $coursRepository){
        // On va chercher toutes les catégories
        $categories = $categRepo->findAll();

        $categNom = [];
        $categColor = [];
        $categCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($categories as $categorie){
            $categNom[] = $categorie->getName();
            $categColor[] = $categorie->getColor();
            $categCount[] = count($categorie->getCours());
        }
        return $this->render('adminh/stats.html.twig', [
            'categNom' => json_encode($categNom),
            'categColor' => json_encode($categColor), 
            'categCount' => json_encode($categCount)
            
        ]);
    }

}
