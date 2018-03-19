<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
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
    private $name;
    /**
     * @ORM\Column(nullable=true)
     * @var clan
     */
    private $id_clan;
    
    /**
     * @ORM\Column()
     * @var user
     */
    private $player;
    
}
