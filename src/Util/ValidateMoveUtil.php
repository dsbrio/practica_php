<?php


namespace App\Util;

use App\Entity\Move;
use App\Entity\State;
use App\Model\EvaluationModel;

use Doctrine\Common\Persistence\ManagerRegistry;

class ValidateMoveUtil
{


    const DEFINED_EVALUATION_MOVE= array(
        "FALLIDO",
        "CORRECTO"
    );

    const MAX_MOVE_GAME=15;


    private $doctrine;


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

                        if ($i == $j) {
                            array_push($blackArray, "X");

                            $auxArray[strval($j)] = $gameMoveArray[$j];
                        }else{
                            array_push($whiteArray, "X");
                        }

                        break;
                    }
                }else if(count($auxArray)>0 && -1==$auxArray[strval($j)]){

                    if ($moveInfoArray[$i] == $gameMoveArray[$j]) {

                        if ($i == $j) {
                            array_push($blackArray, "X");

                            $auxArray[strval($j)] = $gameMoveArray[$j];
                        }else{
                            array_push($whiteArray, "X");
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
                //Jugadas restantes.

                $totalMove = $this->getMove($game->getId());

                if(count($totalMove)==0){

                    $evaluationModel->setRestNumMove(ValidateMoveUtil::MAX_MOVE_GAME-1);

                }else{
                    $evaluationModel->setRestNumMove(ValidateMoveUtil::MAX_MOVE_GAME - (count($totalMove)+1));
                }

                echo $evaluationModel->getRestNumMove();

                if( $evaluationModel->getRestNumMove()===0){

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


        //Seteamos el valor de los blancos y negros.
        $evaluationModel->setBlack($blackArray);
        $evaluationModel->setWhite($whiteArray);

        //seteamos el valor de la jugada si es correcta o no.
        $evaluationModel->setMoveEvaluation($evaluation);

        return $evaluationModel;
    }



    //obtenemos la lista de movimientos.
    private function getMove($gameId){

        $movesInfo = $this->getDoctrine()
            ->getRepository(Move::class)
            ->findBy(array(
                'masterMindGame' =>$gameId
            ));


        return $movesInfo;
    }

    //Actualizamos el juego con su nuevo estado.
    private function updateGame($game){

        //obtenemos el acceso a la BD
        $em = $this->getDoctrine()->getManager();

        // guardar en BD
        $em->persist($game);

        // ejecutar (realmente) la query
        $em->flush();


    }


    //Validamos que el movimiento sea correcto.
    private function validateMaxMove($gameId){

        $validate = true;

        $movesInfo = $this->getDoctrine()
            ->getRepository(Move::class)
            ->findBy(array(
                'masterMindGame' =>$gameId
            ));


        if(null!=$movesInfo && (count($movesInfo)+1) >= ValidateMoveUtil::MAX_MOVE_GAME){
            //si el numero de jugadas, mas la actual supera el maximo, entonces fin del juego.
            $validate = false;
        }

        return $validate;
    }

    /**
     * @return mixed
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @param mixed $doctrine
     */
    public function setDoctrine($doctrine): void
    {
        $this->doctrine = $doctrine;
    }


}