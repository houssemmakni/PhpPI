<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $titre_article = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $description_article = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $prix = null;

   

    /**
     * @Assert\File(maxSize="5M")
     */
    private ?UploadedFile $imageFile = null;

    
    #[ORM\ManyToOne(inversedBy: 'link')]
    private ?Commande $linka = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qrCode;


    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreArticle(): ?string
    {
        return $this->titre_article;
    }

    public function setTitreArticle(?string $titre_article): static
    {
        $this->titre_article = $titre_article;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescriptionArticle(): ?string
    {
        return $this->description_article;
    }

    public function setDescriptionArticle(?string $description_article): static
    {
        $this->description_article = $description_article;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    public function setImageFile(?UploadedFile $imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function getLinka(): ?Commande
    {
        return $this->linka;
    }

    public function setLinka(?Commande $linka): static
    {
        $this->linka = $linka;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(?string $qrCode): self
    {
        $this->qrCode = $qrCode;

        return $this;
    }

}
