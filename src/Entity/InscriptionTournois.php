<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionTournoisRepository")
 */
class InscriptionTournois
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @var int 
     */
    private $id_user;
    
    /**
     * @ORM\Column(type="integer")
     * @var int 
     */
    private $id_tournois;
    
    function getId() {
        return $this->id;
    }

    function getIdUser() {
        return $this->id_user;
    }

    function getIdTournois() {
        return $this->id_tournois;
    }

    function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    function setIdTournois($id_tournois) {
        $this->id_tournois = $id_tournois;
    }


}
