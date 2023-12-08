<?php

namespace App\Services;
use Endroid\QrCode\Encoding\Encoding;
use Endoid\Qrcode\Builder\BuilderInterface; // Correct namespace for BuilderInterface
use Endroid\QrCode\Builder\BuilderInterface as BuilderBuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel;
use Doctrine\ORM\EntityManagerInterface; 
use App\Entity\User;

class QrcodeService {
    
    protected $builder;
    protected $entityManager;

    public function __construct(BuilderBuilderInterface $builder, EntityManagerInterface $entityManager) {
        $this->builder = $builder;
        $this->entityManager = $entityManager;
    }
      
    public function qrcodeFromUserId(int $userId){
        // Récupérer les données de l'utilisateur en fonction de son ID
        // Remplacez UserEntity par votre entité utilisateur réelle
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        
        if(!$user) {
            throw new \Exception('User not found'); // Gérer le cas où l'utilisateur n'est pas trouvé
        }
        $userData = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            // ... Ajoutez d'autres champs si nécessaire
        ];
        
        
        $result = $this-> builder
        ->data(json_encode($userData))
        ->size(400)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->margin(10)


        ->build();
        $fileName = uniqid('','').'.png';
        $result->saveToFile((\dirname(__DIR__, 2).'/public/assets/qr-code/'.$fileName));

        return  $result->getDataUri();

    }
}
