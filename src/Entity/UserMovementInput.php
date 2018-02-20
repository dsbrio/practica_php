<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class UserMovementInput
{
    /**
     * @Assert\Regex(
     * pattern="/^([0-9],){5}[0-9]$/",
     * message="Debes escribir 6 números entre el 0 y el 9"
     * )
     */
    public  $inputString; //validación del input del usuario con esta expresión regular

}
