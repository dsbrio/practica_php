<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;

class NewGameController extends Controller
{
    /**
      * @Route("/new/", name="new")
      */
    public function start()
    {

         // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $newGame = new MasterMindGame();
        $newGame->setName('MMGame1');
        $newGame->setCreationDate(new \DateTime());

        // guardar en BD
        $em->persist($newGame);

        // ejecutar (realmente) la query
        $em->flush();

        return $this->render('games/game.html.twig', array(
            'id' => $newGame->getId(),
            'creationDate' => $newGame->getCreationDate()->format('Y-m-d H:i:s'),
            'state' => "TODO obtener estado de la entity :D"

        ));
    }
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