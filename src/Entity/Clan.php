<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClanRepository")
 */
class Clan
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
     * @ORM\Column()
     * @Assert\NotBlank()
     * @var string 
     */
    private $name;
    
    /**
     * @ORM\Column()
     * @var string
     */
    private $description;
    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @var \Datetime
     */
    private $creation;
    
    /**
     * @ORM\Column(nullable=true)
     * @Assert\Image()
     * @var string
     */
    private $logo;
    
    function __construct() {
        $this->creation = new \DateTime('now');
    }
    
    function getId() {
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCreation() {
        return $this->creation;
    }


    public function getLogo(){
        return $this->logo;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setCreation(\Datetime $creation) {
        $this->creation = $creation;
        return $this;
    }

    public function setLogo($logo) {
        $this->logo = $logo;
        return $this;
    }


    function getIdUser() {
        return $this->id_user;
    }

    function setIdUser($id_user) {
        $this->id_user = $id_user;
        return $this;
    }


}
