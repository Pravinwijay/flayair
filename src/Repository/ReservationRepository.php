<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
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
