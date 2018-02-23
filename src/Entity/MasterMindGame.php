<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MasterMindGameRepository")
 */
class MasterMindGame
{

    const DEFINED_COLORS = array(
        "RED",
        "BLUE",
        "GREEN",
        "YELLOW",
        "ORANGE",
        "GREY",
        "WHITE",
        "BLACK",
        "PINK"
    );

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
   
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    private $colorList;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $state;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getColorList()
    {
        return $this->colorList;
    }

    public function setColorList($colorList)
    {
        $this->colorList = $colorList;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }
}

abstract class State
{
    const STARTED = "Empezada";
    const FINISH_WON = "¡Victoria! ;)";
    const FINISH_LOST = "Derrota :(";
}
