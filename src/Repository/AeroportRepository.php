<?php

namespace App\Repository;

use App\Entity\Aeroport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AeroportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aeroport::class);
    }

    public function findAllWithVille()
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.nomAeroport AS aeroport, v.nom AS ville')
            ->join('a.ville', 'v')
            ->orderBy('v.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}