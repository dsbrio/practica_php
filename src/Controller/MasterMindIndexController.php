<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use App\Entity\MasterMindMove;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;

class MasterMindIndexController extends Controller
{
    /**
      * @Route("/", name = "index")
      */
    public function start()
    {
        $games = $this->getDoctrine()
        ->getRepository(MasterMindGame::class)
        ->findAll();

        return $this->render('index.html.twig', array(
            'games' => $games
        ));
    }

    /**
      * @Route("/games/{gameid}", name="games")
      */
      public function obtainGameDetails($gameid)
      {

            //Realizamos la busqueda por ID
            $gameInfo = $this->getDoctrine()
                    ->getRepository(MasterMindGame::class)
                    ->find($gameid);


            //buscamos las jugadas realizadas




            //Formateamos la fecha.
            $createDateString = date_format($gameInfo->getCreationDate(), 'd-m-Y');

            return $this->render('./games/game.html.twig', array(
                'name' => $gameInfo -> getName(),
                'state' => $gameInfo->getState(),
                'creationDate' => $createDateString
            ));

            /*return new Response(
                '<html><body>Buscar el juego: '.$gameid.'</body></html>'
            );*/
      }
}