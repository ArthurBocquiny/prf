<?php

namespace App\Repository;

use App\Entity\SearchGames;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SearchGames|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchGames|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchGames[]    findAll()
 * @method SearchGames[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchGamesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SearchGames::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
