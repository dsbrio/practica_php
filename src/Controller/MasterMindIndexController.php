<?php

namespace App\Controller;


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
      * @Route("/detail/{gameid}", name="detail")
      */
      public function obtainGameDetails($gameid)
      {

            //Realizamos la busqueda por ID
            $gameInfo = $this->getDoctrine()
                    ->getRepository(MasterMindGame::class)
                    ->find($gameid);


            //buscamos las jugadas realizadas


            //Formateamos la fecha.
            $createDateString =  $gameInfo->getCreationDate()->format('Y-m-d H:i:s');

            return $this->render('./games/game.html.twig', array(
                'name' => $gameInfo -> getName(),
                'state' => $gameInfo->getState(),
                'creationDate' => $createDateString
            ));
      }
}