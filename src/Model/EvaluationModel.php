<?php


namespace App\Model;


class EvaluationModel
{

    //lista de colores  correctos y posicion correcta
    private $black;

    //lista de colores correctos
    private $white;

    //Numero de movimientos.
    private $maxNumMove;

    //indica si el juego es ganado o no.
    private $winGame;

    //lista de movimientos.
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

    /**
     * @return mixed
     */
    public function getWinGame()
    {
        return $this->winGame;
    }

    /**
     * @param mixed $winGame
     */
    public function setWinGame($winGame): void
    {
        $this->winGame = $winGame;
    }



}