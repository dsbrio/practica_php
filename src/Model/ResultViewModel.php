<?php

namespace App\Model;

class ResultViewModel{

    private $blackString;

    private $whiteString;


    /**
     * Get the value of blackString
     */ 
    public function getBlackString()
    {
        return $this->blackString;
    }

    /**
     * Set the value of blackString
     *
     * @return  self
     */ 
    public function setBlackString($blackString)
    {
        $this->blackString = $blackString;

        return $this;
    }

    /**
     * Get the value of whiteString
     */ 
    public function getWhiteString()
    {
        return $this->whiteString;
    }

    /**
     * Set the value of whiteString
     *
     * @return  self
     */ 
    public function setWhiteString($whiteString)
    {
        $this->whiteString = $whiteString;

        return $this;
    }
}

