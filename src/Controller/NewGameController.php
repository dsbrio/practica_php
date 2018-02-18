<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;
use App\Entity\State;

class NewGameController extends Controller
{
    /**
      * @Route("/new/", name="new")
      */
    public function start()
    {
        $newGame = new MasterMindGame();
        $newGame->setName('MMGame1');
        $newGame->setCreationDate(new \DateTime());
        $newGame->setColorList(
            array(
                rand(0,8),
                rand(0,8),
                rand(0,8),
                rand(0,8)
            )
        );
        $newGame->setState(State::STARTED);

        //obtenemos el acceso a la BD
        $em = $this->getDoctrine()->getManager();

        // guardar en BD
        $em->persist($newGame);

        // ejecutar (realmente) la query
        $em->flush();

        return $this->render('games/game.html.twig', array(
            'id' => $newGame->getId(),
            'creationDate' => $newGame->getCreationDate()->format('Y-m-d H:i:s'),
            'state' => $newGame->getState(),
            'color' => MasterMindGame::DEFINED_COLORS[
                $newGame->getColorList()[0]
                ]
        ));
    }
}
