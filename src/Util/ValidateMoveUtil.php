<?php


namespace App\Util;

use App\Entity\Move;
use App\Model\EvaluationModel;


class ValidateMoveUtil
{


    const DEFINED_EVALUATION_MOVE= array(
        "FAIL",
        "OK"
    );

    public function  validateMove($moveInfo, $game){

        $evaluationModel = new EvaluationModel();

        //array con las posiciones que se han cubierto para no tener en cuenta las posiciones repetidas.
        $auxArray = array(
            "0" =>-1,
            "1" =>-1,
            "2" =>-1,
            "3" =>-1,
            "4" =>-1,
            "5" =>-1

        );

        //array con los aciertos de color y posición
        $blackArray = array();

        //array con los aciertos de color.
        $whiteArray = array();

        //por defecto, fail.
        $evaluation = ValidateMoveUtil::DEFINED_EVALUATION_MOVE[0];

        //realizamos split del movimiento introducido por el usuario
        $moveInfoArray = explode(',', $moveInfo);

        //obtenemos el array de elementos generado para el juego.
        $gameMoveArray = $game->getColorList();

        //recorremos toda la lista y comprobamos que se encuentra en la posición correcta y es el color correcto.
        for ($i = 0; $i < count($moveInfoArray); $i++) {

            for ($j = 0; $j <  count($gameMoveArray); $j++) {

                if(count($auxArray)==0) {

                    if ($moveInfoArray[$i] == $gameMoveArray[$j]) {

                        array_push($whiteArray, "X");

                        if ($i == $j) {
                            array_push($blackArray, "X");

                            $auxArray[strval($j)] = $gameMoveArray[$j];
                        }

                        break;
                    }
                }else if(count($auxArray)>0 && -1==$auxArray[strval($j)]){

                    if ($moveInfoArray[$i] == $gameMoveArray[$j]) {

                        array_push($whiteArray, "X");

                        if ($i == $j) {
                            array_push($blackArray, "X");

                            $auxArray[strval($j)] = $gameMoveArray[$j];
                        }

                        break;
                    }

                }
            }
        }

        echo count($whiteArray);
        echo count($blackArray);
        echo count($gameMoveArray);

        if(count($whiteArray)=== count($blackArray) &&
            count($whiteArray)=== count($gameMoveArray) &&
            count($blackArray)=== count($gameMoveArray)){

            //si la longitud de los 3 arrays es la misma, entonces es correcta la combinación.
            $evaluation = ValidateMoveUtil::DEFINED_EVALUATION_MOVE[1];
        }else{


            //TODO numero de intentos.
        }



        $move = new Move();
        $move->setMasterMindGame($game);
        $move->setDate(new \DateTime());
        $move->setColorList($moveInfoArray);

        $move->setEvaluation($evaluation);

        $evaluationModel->setMove($move);
        return $evaluationModel;
    }


}