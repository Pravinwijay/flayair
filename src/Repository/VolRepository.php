<?php

namespace App\Repository;

use App\Entity\Vol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vol>
 */
class VolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vol::class);
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.aeroportDepart', 'ad')
            ->addSelect('ad')
            ->leftJoin('v.aeroportArrive', 'aa')
            ->addSelect('aa')
            ->getQuery()
            ->getResult();
    }
    
}
