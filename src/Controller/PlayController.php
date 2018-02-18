<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\State;

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


            if(null!==$game && State::STARTED===$game->getState()){

                //La partida no ha finalizado, puede continuarla.
                return $this->render('games/play.html.twig', array(
                    'name' => $game->getName(),
                ));
            }else if(null!==$game && State::STARTED!==$game->getState()){

                $state = $game->getState();

                return $this->render('error/error.html.twig', array(
                    'error' => "La partida ha finalizado con resultado: $state . Seleccione otra partida o cree una nueva.",
                ));
            }else{
                return $this->render('error/error.html.twig', array(
                    'error' => 'Error en la selección de la partida, por favor, inicie una nueva.',
                ));
            }



      }
}