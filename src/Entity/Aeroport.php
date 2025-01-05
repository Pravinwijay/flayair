<?php

namespace App\Entity;

use App\Repository\AeroportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AeroportRepository::class)]
class Aeroport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAeroport = null;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $ville = null; 

    #[ORM\OneToMany(mappedBy: 'aeroportDepart', targetEntity: Vol::class)]
    private Collection $volsDepart; 

    #[ORM\OneToMany(mappedBy: 'aeroportArrive', targetEntity: Vol::class)]
    private Collection $volsArrive; 

    public function __construct()
    {
        $this->volsDepart = new ArrayCollection(); 
        $this->volsArrive = new ArrayCollection(); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAeroport(): ?string
    {
        return $this->nomAeroport;
    }

    public function setNomAeroport(string $nomAeroport): static
    {
        $this->nomAeroport = $nomAeroport;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Vol>
     */
    public function getVolsDepart(): Collection
    {
        return $this->volsDepart;
    }
}