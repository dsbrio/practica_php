<?php

namespace App\Model;

class ColorModel{

    private $colorName;

    /**
     * @return mixed
     */
    public function getColorName()
    {
        return $this->colorName;
    }

    /**
     * @param mixed $colorName
     */
    public function setColorName($colorName): void
    {
        $this->colorName = $colorName;
    }





}