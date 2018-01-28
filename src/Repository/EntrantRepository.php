<?php

namespace App\Repository;

use App\Entity\Entrant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EntrantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entrant::class);
    }

    public function findAllOrderedByScore()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.score', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
