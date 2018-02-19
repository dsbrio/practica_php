<?php


namespace App\Model;


class EvaluationModel
{

    private $black;

    private $white;

    private $maxNumMove;

    private $move;


    /**
     * @return mixed
     */
    public function getBlack()
    {
        return $this->black;
    }

    /**
     * @param mixed $black
     */
    public function setBlack($black): void
    {
        $this->black = $black;
    }

    /**
     * @return mixed
     */
    public function getWhite()
    {
        return $this->white;
    }

    /**
     * @param mixed $white
     */
    public function setWhite($white): void
    {
        $this->white = $white;
    }

    /**
     * @return mixed
     */
    public function getMaxNumMove()
    {
        return $this->maxNumMove;
    }

    /**
     * @param mixed $maxNumMove
     */
    public function setMaxNumMove($maxNumMove): void
    {
        $this->maxNumMove = $maxNumMove;
    }

    /**
     * @return mixed
     */
    public function getMove()
    {
        return $this->move;
    }

    /**
     * @param mixed $move
     */
    public function setMove($move): void
    {
        $this->move = $move;
    }



}