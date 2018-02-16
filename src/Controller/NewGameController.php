<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class NewGameController extends Controller
{
    /**
      * @Route("/new/", name="new")
      */
    public function start()
    {
        $newGame = new MasterMindGame();
        $newGame->creationDate = date("F j, Y, g:i a");
        $newGame->colorList = array(
            rand ( 0 , 8 ),
            rand ( 0 , 8 ),
            rand ( 0 , 8 ),
            rand ( 0 , 8 )
        );
        $newGame->state = State::STARTED;

        return $this->render('games/game.html.twig', array(
            'id' => "123",
            'creationDate' => $newGame->creationDate,
            'state' => $newGame->state,

        ));
    }
}

class MasterMindGame { 
    public $name; 
    public $creationDate; 
    public $colorList;
    public $state;
    public $moves;
}

abstract class Colors
{
    const RED = 0;
    const BLUE = 1;
    const GREEN = 2;
    const YELLOW = 3;
    const ORANGE = 4;
    const GREY = 5;
    const WHITE = 6;
    const BLACK = 7;
    const PINK = 8;
}

abstract class State
{
    const STARTED = "Empezada";
    const FINISH_WON = "¡Victoria! ;)";
    const FINISH_LOST = "Derrota :(";
}