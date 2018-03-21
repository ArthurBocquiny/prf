<?php

namespace App\Repository;

use App\Entity\Clan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clan[]    findAll()
 * @method Clan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clan::class);
    }
    
    
    public function searchIdUser($id) {
        
        return $this->createQueryBuilder('c')
                ->where('c.id_user = :id_user')->setParameter('id_user', $id)
                ->getQuery()->getResult()
        ;
    }
    
    
      public function findNameClan($id) {
        
        return $this->createQueryBuilder('d')
                ->where('d.id = :id')->setParameter('id', $id)
                ->getQuery()->getResult()
        ;
    }
    
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
