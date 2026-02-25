<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?float $montant = 0;

    #[ORM\OneToMany(mappedBy: "commande", targetEntity: Achat::class, cascade: ["persist"], orphanRemoval: true)]
    private Collection $achats;

    public function __construct()
    {
        $this->achats = new ArrayCollection();
        $this->date = new \DateTimeImmutable();
    }

    public function addAchat(Achat $achat): self
    {
        $this->achats[] = $achat;
        $achat->setCommande($this);
        return $this;
    }

    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

}