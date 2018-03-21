<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionTeamRepository")
 */
class InscriptionTeam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column()
     * @var int 
     */
    private $id_user;
    
    /**
     * @ORM\Column()
     * @var int 
     */
    private $id_team;
    
    function getId() {
        return $this->id;
    }

    function getIdUser() {
        return $this->id_user;
    }

    function getIdTeam() {
        return $this->id_team;
    }

    function setIdUser($id_user) {
        $this->id_user = $id_user;
        return $this;
    }

    function setIdTeam($id_team) {
        $this->id_team = $id_team;
        return $this;
    }
}
