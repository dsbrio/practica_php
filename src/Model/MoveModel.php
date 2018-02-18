<?php

namespace App\Model;

class MoveModel{

    private $evaluation;

    private $date;

    private $colorList;

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

}

