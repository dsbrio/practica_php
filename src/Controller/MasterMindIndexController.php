<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;
use App\Entity\Move;
use App\Util\ValidateMoveUtil;

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


                    $validationMove = new ValidateMoveUtil();
                    $validationMove->setDoctrine($this->getDoctrine());

                    //validamos cada movimiento
                    $resultViewModel = $validationMove->getResultViewModel(implode(',', $value->getColorList()), $gameInfo);
                    $blackArray = $resultViewModel->getBlackArray();
                    $whiteArray = $resultViewModel->getWhiteArray();

                    //montamos 2 strings ya preparadas para mostrarlas al usuario en función de las casillas blancas y negras de la validación
                    $blackString = '';
                    for ($j = 0; $j < count($blackArray); $j++) {
                        $blackString .= '(X)';
                    }
                    $whiteString = '';
                    for ($k = 0; $k < count($whiteArray); $k++) {
                        $whiteString .= '( )';
                    }
                    $move->setBlackString($blackString);
                    $move->setWhiteString($whiteString);

                    $move->setColorList(implode(',', $value->getColorList()));

                    array_push($moves, $move);
                }
            }

            return $this->render('./games/game.html.twig', array(
                'name' => $gameInfo -> getName(),
                'state' => $gameInfo->getState(),
                'creationDate' => $gameInfo->getCreationDate()->format('Y-m-d H:i:s'),
                'moves' => $moves,
                'gameid' => $gameid
            ));
      }
}