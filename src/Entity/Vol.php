<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VolRepository::class)]
class Vol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $numVol = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duree = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $heureDepart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $heureArrive = null;

    #[ORM\Column(type: 'integer')]
    private ?int $nbPassagers = null;

    #[ORM\Column(type: 'float')]
    private ?float $prixVol = null;

    #[ORM\ManyToOne(targetEntity: Avion::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Avion $avion = null;

    #[ORM\ManyToOne(targetEntity: Aeroport::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aeroport $aeroportDepart = null;

    #[ORM\ManyToOne(targetEntity: Aeroport::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aeroport $aeroportArrive = null;

    #[ORM\OneToMany(mappedBy: 'vol', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumVol(): ?string
    {
        return $this->numVol;
    }

    public function setNumVol(string $numVol): static
    {
        $this->numVol = $numVol;
        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): static
    {
        $this->duree = $duree;
        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(\DateTimeInterface $heureDepart): static
    {
        $this->heureDepart = $heureDepart;
        return $this;
    }

    public function getHeureArrive(): ?\DateTimeInterface
    {
        return $this->heureArrive;
    }

    public function setHeureArrive(\DateTimeInterface $heureArrive): static
    {
        $this->heureArrive = $heureArrive;
        return $this;
    }

    public function getNbPassagers(): ?int
    {
        return $this->nbPassagers;
    }

    public function setNbPassagers(int $nbPassagers): static
    {
        $this->nbPassagers = $nbPassagers;
        return $this;
    }

    public function getPrixVol(): ?float
    {
        return $this->prixVol;
    }

    public function setPrixVol(float $prixVol): static
    {
        $this->prixVol = $prixVol;
        return $this;
    }

    public function getAvion(): ?Avion
    {
        return $this->avion;
    }

    public function setAvion(?Avion $avion): static
    {
        $this->avion = $avion;
        return $this;
    }

    public function getAeroportDepart(): ?Aeroport
    {
        return $this->aeroportDepart;
    }

    public function setAeroportDepart(?Aeroport $aeroportDepart): static
    {
        $this->aeroportDepart = $aeroportDepart;
        return $this;
    }

    public function getAeroportArrive(): ?Aeroport
    {
        return $this->aeroportArrive;
    }

    public function setAeroportArrive(?Aeroport $aeroportArrive): static
    {
        $this->aeroportArrive = $aeroportArrive;
        return $this;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setVol($this);
        }
        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
        }
        return $this;
    }
}
