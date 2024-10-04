<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use App\Entity\CategUtilisateur;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    
    #[ORM\ManyToOne(targetEntity:CategUtilisateur::class)]
    #[ORM\JoinColumn(nullable:false)]
    private ?categUtilisateur $categUtilisateur = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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
