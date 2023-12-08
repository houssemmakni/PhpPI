<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateReclamation = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;


    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = 'On Hold';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Response = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateReponse = null;

    #[ORM\Column(length: 255)]
    private ?string $Subject = null;

    #[ORM\Column(length: 255)]
    private ?string $userEmail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReclamation(): ?\DateTimeInterface
    {
        return $this->dateReclamation;
    }

    public function setDateReclamation(\DateTimeInterface $dateReclamation): static
    {
        $this->dateReclamation = $dateReclamation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->Response;
    }

    public function setResponse(?string $Response): static
    {
        $this->Response = $Response;

        return $this;
    }

    public function getDateReponse(): ?\DateTimeInterface
    {
        return $this->DateReponse;
    }

    public function setDateReponse(?\DateTimeInterface $DateReponse): static
    {
        $this->DateReponse = $DateReponse;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->Subject;
    }

    public function setSubject(string $Subject): static
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): static
    {
        $this->userEmail = $userEmail;

        return $this;
    }
}