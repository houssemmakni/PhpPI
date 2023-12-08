<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


   
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $addresse_commande = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nom_prenom_commande = null;


    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tel_commande = null;

    #[ORM\OneToMany(mappedBy: 'linka', targetEntity: article::class)]
    private Collection $link;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idarticle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $totalPrice = null;

    #[ORM\Column(length: 255, nullable: true)]

    private ?string $nomarticle = null;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $dateCommande;
   



    public function __construct()
    {
        $this->link = new ArrayCollection();
    }
    
    
    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAddresseCommande(): ?string
    {
        return $this->addresse_commande;
    }

    public function setAddresseCommande(?string $addresse_commande): static
    {
        $this->addresse_commande = $addresse_commande;

        return $this;
    }

    public function getNomPrenomCommande(): ?string
    {
        return $this->nom_prenom_commande;
    }

    public function setNomPrenomCommande(?string $nom_prenom_commande): static
    {
        $this->nom_prenom_commande = $nom_prenom_commande;

        return $this;
    }

    public function getTelCommande(): ?string
    {
        return $this->tel_commande;
    }

    public function setTelCommande(?string $tel_commande): static
    {
        $this->tel_commande = $tel_commande;

        return $this;
    }

    /**
     * @return Collection<int, article>
     */
    public function getLink(): Collection
    {
        return $this->link;
    }

    public function addLink(article $link): static
    {
        if (!$this->link->contains($link)) {
            $this->link->add($link);
            $link->setLinka($this);
        }

        return $this;
    }

    public function removeLink(article $link): static
    {
        if ($this->link->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getLinka() === $this) {
                $link->setLinka(null);
            }
        }

        return $this;
    }

    public function getIdarticle(): ?string
    {
        return $this->idarticle;
    }

    public function setIdarticle(?string $idarticle): static
    {
        $this->idarticle = $idarticle;

        return $this;
    }

    public function getNomarticle(): ?string
    {
        return $this->nomarticle;
    }

    public function setNomarticle(?string $nomarticle): static
    {
        $this->nomarticle = $nomarticle;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

}
