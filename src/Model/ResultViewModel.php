<?php

namespace App\Model;

class ResultViewModel{

    private $blackArray;

    private $whiteArray;

    private $moveString;

 
    /**
     * Get the value of blackArray
     */ 
    public function getBlackArray()
    {
        return $this->blackArray;
    }

    /**
     * Set the value of blackArray
     *
     * @return  self
     */ 
    public function setBlackArray($blackArray)
    {
        $this->blackArray = $blackArray;

        return $this;
    }

    /**
     * Get the value of whiteArray
     */ 
    public function getWhiteArray()
    {
        return $this->whiteArray;
    }

    /**
     * Set the value of whiteArray
     *
     * @return  self
     */ 
    public function setWhiteArray($whiteArray)
    {
        $this->whiteArray = $whiteArray;

        return $this;
    }

    /**
     * Get the value of moveString
     */ 
    public function getMoveString()
    {
        return $this->moveString;
    }

    /**
     * Set the value of moveString
     *
     * @return  self
     */ 
    public function setMoveString($moveString)
    {
        $this->moveString = $moveString;

        return $this;
    }

}

