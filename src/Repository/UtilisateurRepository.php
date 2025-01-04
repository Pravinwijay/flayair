<?php

// src/Repository/UtilisateurRepository.php
namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function findOneByEmail($email)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.mail = :mail')
            ->setParameter('mail', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

