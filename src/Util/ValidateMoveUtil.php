<?php


namespace App\Util;

use App\Entity\Move;
use App\Entity\State;
use App\Model\EvaluationModel;


class ValidateMoveUtil
{


    const DEFINED_EVALUATION_MOVE= array(
        "FAIL",
        "OK"
    );

    const MAX_MOVE_GAME=3;


    private function validateMaxMove($gameid){

        $validate = true;

        $movesInfo = $this->getDoctrine()
            ->getRepository(Move::class)
            ->findBy(array(
                'masterMindGame' =>$gameid
            ));


        if(null!=$movesInfo && (count($movesInfo)+1) >= ValidateMoveUtil::MAX_MOVE_GAME){
            //si el numero de jugadas, mas la actual supera el maximo, entonces fin del juego.
            $validate = false;
        }

        return $validate;
    }


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

        if(count($whiteArray)=== count($blackArray) &&
            count($whiteArray)=== count($gameMoveArray) &&
            count($blackArray)=== count($gameMoveArray)){

            //si la longitud de los 3 arrays es la misma, entonces es correcta la combinación.
            $evaluation = ValidateMoveUtil::DEFINED_EVALUATION_MOVE[1];

            //Actualizamos el estado del juego a victoria.
            $game->setState(State::FINISH_WON);

            //actualizamos el juego en la base de datos.
            $this->updateGame($game);

            //Indicamos que la partida se ha ganado.
            $evaluationModel->setWinGame(true);

        }else{

            if(!$this->validateMaxMove($game->getId())){
                //se ha alcanzado el máximo de intentos, 15.

                //Actualizamos el estado del juego a derrota.
                $game->setState(State::FINISH_LOST);

                //actualizamos el juego en la base de datos.
                $this->updateGame($game);

                //Indicamos que se ha obtenido el maximo de movimientos.
                $evaluationModel->setMaxNumMove(ValidateMoveUtil::MAX_MOVE_GAME);

                //indicamos que se ha perdido el juego.
                $evaluationModel->setWinGame(false);

            }

        }

        //componemos el movimiento que se va a almacenar.
        $move = new Move();
        $move->setMasterMindGame($game);
        $move->setDate(new \DateTime());
        $move->setColorList($moveInfoArray);
        $move->setEvaluation($evaluation);

        $this->insertMove($move);

        //Seteamos el valor de los blancos y negros.
        $evaluationModel->setBlack($blackArray);
        $evaluationModel->setWhite($whiteArray);

        //obtenemos el listado de todos los movimientos realizados.
        $evaluationModel->setMove($this->getMove($game->getId()));

        return $evaluationModel;
    }



    private function getMove($gameId){

        //TODO
    }

    private function updateGame($game){
        //TODO
    }

    //Función que inserta el movimiento en base de datos.
    private function insertMove($move){

        //obtenemos el acceso a la BD
        $em = $this->getDoctrine()->getManager();

        // guardar en BD
        $em->persist($move);

        // ejecutar (realmente) la query
        $em->flush();
    }


}