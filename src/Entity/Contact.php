<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContactRepository;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column()
     * @var string
     */
    private $object;
    
    /**
     * @ORM\Column()
     * @var string
     */
    private $message;
    
    
    /**
     * @ORM\Column()
     * @var string
     */
    private $email;
    
    /**
     * @ORM\Column()
     * @var string
     */
    private $name;
    
    function getId() {
        return $this->id;
    }

    function getObject() {
        return $this->object;
    }

    function getMessage() {
        return $this->message;
    }


    function getEmail() {
        return $this->email;
    }

    function getName() {
        return $this->name;
    }

    function setObject($object) {
        $this->object = $object;
        return $this;
    }

    function setMessage($message) {
        $this->message = $message;
        return $this;
    }


    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setName($name) {
        $this->name = $name;
        return $this;
    }


}
