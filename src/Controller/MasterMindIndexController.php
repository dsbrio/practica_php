<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;
use App\Entity\Move;


use App\Model\MoveModel;
use App\Model\ColorModel;

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
            $movesInfo = $this->getDoctrine()
              ->getRepository(Move::class)
              ->findBy(array(
                    'masterMindGame' =>$gameid
              ));

            //Adaptamos los datos de la base de datos a la salida. Creamos array para pintar
            $moves = array();

            if(null!==$movesInfo && !empty($movesInfo)){
                //Existen datos en la recuperación de jugadas de la base de datos.

                foreach ($movesInfo as $value) {

                    $move = new MoveModel();

                    //añadimos el estado de la jugada, si es correcta o no.
                    $move->setEvaluation($value->getEvaluation());

                    //añadimos la fecha de la jugada.
                    $move->setDate($value->getDate()->format('Y-m-d H:i:s'));

                    //lista de colores.

                    $colors = array();
                    foreach ($value->getColorList() as $color) {

                        $colorModel = new ColorModel();

                        $colorModel->setColorName($color);

                        array_push($colors, $colorModel);
                    }

                    $move->setColorList($colors);

                    array_push($moves, $move);
                }
            }

            return $this->render('./games/game.html.twig', array(
                'name' => $gameInfo -> getName(),
                'state' => $gameInfo->getState(),
                'creationDate' => $gameInfo->getCreationDate()->format('Y-m-d H:i:s'),
                'moves' => $moves
            ));
      }
}