<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoveRepository")
 */
class Move
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity="MasterMindGame")
     */
    private $masterMindGame;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    private $colorList;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $evaluation;

    
    /**
     * Get the value of colorList
     */ 
    public function getColorList()
    {
        return $this->colorList;
    }

    /**
     * Set the value of colorList
     *
     * @return  self
     */ 
    public function setColorList($colorList)
    {
        $this->colorList = $colorList;

        return $this;
    }



    /**
     * Get the value of evaluation
     */ 
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * Set the value of evaluation
     *
     * @return  self
     */ 
    public function setEvaluation($evaluation)
    {
        $this->evaluation = $evaluation;

        return $this;
    }


    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMasterMindGame()
    {
        return $this->masterMindGame;
    }

    /**
     * @param mixed $masterMindGame
     */
    public function setMasterMindGame($masterMindGame): void
    {
        $this->masterMindGame = $masterMindGame;
    }

}
