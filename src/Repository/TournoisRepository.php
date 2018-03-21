<?php

namespace App\Repository;

use App\Entity\InscriptionTournois;
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

    
    public function findNextTournois($limit)
    {
        $qb = $this->createQueryBuilder('t');
        
        $qb
            ->orderBy('t.date', 'ASC')
            ->setMaxResults($limit);
            
            
            return $qb->getQuery()->getResult();
        ;
    }
    
    public function tournoisUser($iduser)
    {
        $connect = $this->getEntityManager()->getConnection();
        
        $sql =  "SELECT t.categorie, t.jeu, t.date, i.id
                FROM tournois t
                JOIN inscription_tournois i
                WHERE i.id_tournois = t.id
                AND i.id_user =".$iduser." ORDER BY date";
        
        $result = $connect->query($sql);
            
            return $result->fetchAll();
        ;
    }
    
    public function countTournois()
    {
        $connect = $this->getEntityManager()->getConnection();
        
        $sql =  "SELECT COUNT(jeu)
                FROM tournois
                GROUP BY jeu";
        
        $result = $connect->query($sql);
            
            return $result->fetchAll();
        ;
    }
    
    public function tournoisJeuName()
    {
        $connect = $this->getEntityManager()->getConnection();
        
        $sql =  "SELECT DISTINCT jeu 
                FROM tournois";
        
        $result = $connect->query($sql);
            
            return $result->fetchAll();
        ;
    }
    
    public function tournoisClan($idclan)
    {
        $connect = $this->getEntityManager()->getConnection();
        
        $sql =  "SELECT t.jeu, t.date, i.id
                FROM tournois t
                JOIN inscription_tournois i
                WHERE i.id_tournois = t.id
                AND t.categorie = 'Clan'
                AND i.id_clan =".$idclan;
        
        $result = $connect->query($sql);
            
            return $result->fetchAll();
        ;
    }
        
}
