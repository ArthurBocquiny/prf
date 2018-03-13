<?php

namespace App\Repository;

use App\Entity\Tournois;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tournois|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournois|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournois[]    findAll()
 * @method Tournois[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournoisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tournois::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('t')
            ->where('t.something = :value')->setParameter('value', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
