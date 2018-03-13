<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TournoisRepository")
 */
class Tournois
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column()
     * @Assert\NotBlank()
     * @var string 
     */
    private $jeu;
    
    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @var \Datetime
     */
    private $date;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @var int
     */
    private $nb_participant_max;
    
    function getId() {
        return $this->id;
    }

    function getJeu() {
        return $this->jeu;
    }

    function getDate(){
        return $this->date;
    }

    function getNbParticipantMax() {
        return $this->nb_participant_max;
    }

    function setJeu($jeu) {
        $this->jeu = $jeu;
    }

    function setDate(\Datetime $date) {
        $this->date = $date;
    }

    function setNbParticipantMax($nb_participant_max) {
        $this->nb_participant_max = $nb_participant_max;
    }


}
