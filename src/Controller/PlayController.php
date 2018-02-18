<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;
use Symfony\Component\HttpFoundation\Response;

class PlayController extends Controller
{

    /**
      * @Route("/games/{gameid}", name="games")
      */
      public function obtainGameDetails($gameid)
      {
         
            $game = $this->getDoctrine()
            ->getRepository(MasterMindGame::class)
            ->find($gameid);

            return $this->render('games/play.html.twig', array(
                'id' => $game->getName(),
            ));
      }
}