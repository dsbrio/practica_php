<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class UserMovementInput
{
    /**
     * @Assert\Regex("/^[0-9]{6}$/")
     */
    public  $inputString; //validación del input del usuario con esta expresión regular

}
