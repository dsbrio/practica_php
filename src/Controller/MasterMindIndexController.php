<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MasterMindIndexController extends Controller
{
    /**
      * @Route("/", name = "index")
      */
    public function start()
    {
        $games = array('juegoMock1', 'juegoMock2', 'juegoMock3');

        return $this->render('index.html.twig', array(
            'games' => $games,
            'saludo' => "PRUEBAAAA"
        ));
    }

    /**
      * @Route("/games/{gameid}", name="games")
      */
      public function obtainGameDetails($gameid)
      {
            return new Response(
                '<html><body>Buscar el juego: '.$gameid.'</body></html>'
            );
      }
}