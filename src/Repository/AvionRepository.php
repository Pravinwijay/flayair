<?php

namespace App\Repository;

use App\Entity\Avion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class AvionRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Avion::class);
        $this->entityManager = $entityManager;
    }

    // Utilisez la méthode de base findAll() sans la redéfinir
    // public function findAll(): array {
    //     return parent::findAll();
    // }

    // Méthode pour enregistrer un avion
    public function save(Avion $avion): void
    {
        $this->entityManager->persist($avion);
        $this->entityManager->flush();
    }

    // Méthode pour insérer un avion (vous pouvez appeler save ici si vous le souhaitez)
    public function insertAvion(Avion $avion): void
    {
        $this->save($avion); // Appelle la méthode save() pour insérer l'avion
    }
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

