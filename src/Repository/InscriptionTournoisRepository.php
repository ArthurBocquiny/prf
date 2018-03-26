<?php

namespace App\Repository;

use App\Entity\InscriptionTournois;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionTournoisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InscriptionTournois::class);
    }
    
     
    public function selectUserTournois($id)
    {
        $qb = $this->createQueryBuilder('i');
        
        $qb
            ->andWhere('i.id_tournois = :id_tournois')
            ->setParameter('id_tournois', $id);
            
            
            
            return $qb->getQuery()->getResult();
   
    }
     
    public function userInscription($id, $actuser)
    {
        $qb = $this->createQueryBuilder('i');
        
        $qb
            ->andWhere('i.id_tournois = :id_tournois')
            ->andWhere('i.id_user = :id_user')
            ->setParameter('id_tournois', $id)
            ->setParameter('id_user', $actuser);

            return $qb->getQuery()->getResult();
    }
     
    public function userClanInscription($id, $idClan)
    {
        $qb = $this->createQueryBuilder('i');
        
        $qb
            ->andWhere('i.id_tournois = :id_tournois')
            ->andWhere('i.id_clan = :id_clan')
            ->setParameter('id_tournois', $id)
            ->setParameter('id_clan', $idClan);

            return $qb->getQuery()->getResult();
    }

}
