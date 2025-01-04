<?php

namespace App\Entity;

use App\Repository\FonctCategRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FonctCategRepository::class)]
class FonctCateg
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: CategUtilisateur::class, inversedBy: 'fonctions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategUtilisateur $categ = null; // Relation vers CategUtilisateur

    #[ORM\ManyToOne(targetEntity: Fonctionnalite::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fonctionnalite $fonctionnalite = null; // Relation vers Fonctionnalite

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCateg(): ?CategUtilisateur
    {
        return $this->categ;
    }

    public function setCateg(CategUtilisateur $categ): static
    {
        $this->categ = $categ;

        return $this;
    }

    public function getFonctionnalite(): ?Fonctionnalite
    {
        return $this->fonctionnalite;
    }

    public function setFonctionnalite(Fonctionnalite $fonctionnalite): static
    {
        $this->fonctionnalite = $fonctionnalite;

        return $this;
    }
}
