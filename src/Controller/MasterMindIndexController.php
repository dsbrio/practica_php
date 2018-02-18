<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

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
            return new Response(
                '<html><body>Buscar el juego: '.$gameid.'</body></html>'
            );
      }
}