<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
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
    private $titre;
   
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @var string
     */
    private $contenu; 
    
    /**
     * @ORM\Column(type="date")
     * @var \Datetime
     */
    private $date;
    
    function getId() {
        return $this->id;
    }

    function getTitre() {
        return $this->titre;
    }

    function getContenu() {
        return $this->contenu;
    }

    function getDate(): \Datetime {
        return $this->date;
    }

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    function setDate(\Datetime $date) {
        $this->date = $date;
    }

    
}
