<?php

namespace App\Repository;

use App\Entity\InscriptionTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InscriptionTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method InscriptionTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method InscriptionTeam[]    findAll()
 * @method InscriptionTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionTeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InscriptionTeam::class);
    }
    
    public function findUserInvit($id)
    {
        return $this->createQueryBuilder('i')
            ->where('i.id_user = :id')->setParameter('id', $id)        
            ->getQuery()
            ->getResult()
        ;
    }
    
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('i')
            ->where('i.something = :value')->setParameter('value', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
