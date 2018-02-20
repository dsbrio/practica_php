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

    //Evaluación del movimiento
    private $moveEvaluation;

    //indica el resto de movimientos que le quedan al usuario.
    private $restNumMove;


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
    public function getMoveEvaluation()
    {
        return $this->moveEvaluation;
    }

    /**
     * @param mixed $moveEvaluation
     */
    public function setMoveEvaluation($moveEvaluation): void
    {
        $this->moveEvaluation = $moveEvaluation;
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

    /**
     * @return mixed
     */
    public function getRestNumMove()
    {
        return $this->restNumMove;
    }

    /**
     * @param mixed $restNumMove
     */
    public function setRestNumMove($restNumMove): void
    {
        $this->restNumMove = $restNumMove;
    }



}