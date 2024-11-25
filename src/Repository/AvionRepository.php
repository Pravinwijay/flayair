<?php

namespace App\Repository;

use App\Entity\Avion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avion>
 */
class AvionRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Avion::class);
        $this->entityManager = $entityManager;
    }

    public function findAll(): array{
        return $this->findAll();
    }

    public function save(Avion $avion){
        $this->entityManager->persist($avion);
        $this->entityManager->flush();
    }

    public function insertAvion(Avion $avion): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($avion);
        $entityManager->flush();
    }

    //    /**
    //     * @return Avion[] Returns an array of Avion objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Avion
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
