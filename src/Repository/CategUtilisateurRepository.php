<?php

namespace App\Repository;

use App\Entity\CategUtilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategUtilisateur>
 */
class CategUtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategUtilisateur::class);
    }
    public function findOneByLibelle(string $libelle): ?CategUtilisateur
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.libelle = :libelle')
            ->setParameter('libelle', $libelle)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
