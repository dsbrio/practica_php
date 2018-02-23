<?php

namespace App\Model;

class MoveModel{

    private $evaluation;

    private $date;

    private $colorList;

    private $blackString;

    private $whiteString;

    /**
     * @return mixed
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * @param mixed $evaluation
     */
    public function setEvaluation($evaluation): void
    {
        $this->evaluation = $evaluation;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getColorList()
    {
        return $this->colorList;
    }

    /**
     * @param mixed $colorList
     */
    public function setColorList($colorList): void
    {
        $this->colorList = $colorList;
    }

    /**
     * @return mixed
     */
    public function getBlackString()
    {
        return $this->blackString;
    }

    /**
     * @param mixed $blackString
     */
    public function setBlackString($blackString): void
    {
        $this->blackString = $blackString;
    }

    /**
     * @return mixed
     */
    public function getWhiteString()
    {
        return $this->whiteString;
    }

    /**
     * @param mixed $whiteString
     */
    public function setWhiteString($whiteString): void
    {
        $this->whiteString = $whiteString;
    }

}

