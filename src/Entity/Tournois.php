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
     * @ORM\Column()
     * @Assert\NotBlank()
     * @var string 
     */
    private $categorie;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @var string 
     */
    private $description;
    
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @var \DateTime
     */
    private $date;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @var int
     */
    private $nb_participant_max;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $nb_participant_actuel;

    
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
    
    function getCategorie() {
        return $this->categorie;
    }

    function getDescription() {
        return $this->description;
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
    
    function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function getNbParticipantActuel() {
        return $this->nb_participant_actuel;
    }

    function setNbParticipantActuel($nb_participant_actuel) {
        $this->nb_participant_actuel = $nb_participant_actuel;
    }


}
