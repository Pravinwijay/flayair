<?php

namespace App\Entity;

use App\Repository\FonctionnaliteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FonctionnaliteRepository::class)]
class Fonctionnalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(targetEntity: CategUtilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategUtilisateur $categUtilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCategUtilisateur(): ?CategUtilisateur
    {
        return $this->categUtilisateur;
    }

    public function setCategUtilisateur(CategUtilisateur $categUtilisateur): static
    {
        $this->categUtilisateur = $categUtilisateur;

        return $this;
    }
}
