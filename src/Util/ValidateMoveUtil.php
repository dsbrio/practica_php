<?php


namespace App\Util;

use App\Entity\Move;
use App\Entity\State;
use App\Model\EvaluationModel;
use App\Model\ResultViewModel;

use Doctrine\Common\Persistence\ManagerRegistry;

class ValidateMoveUtil
{


    const DEFINED_EVALUATION_MOVE= array(
        "FALLIDO",
        "CORRECTO"
    );

    const MAX_MOVE_GAME=15;


    private $doctrine;


    public function validateMove($moveInfo, $game){

        $evaluationModel = new EvaluationModel();

        $resultViewModel = $this->getResultViewModel($moveInfo, $game);

        //array con los aciertos de color y posición
        $blackArray =  $resultViewModel->getBlackArray();
        //array con los aciertos de color.
        $whiteArray = $resultViewModel->getWhiteArray();

        //por defecto, fail.
        $evaluation = ValidateMoveUtil::DEFINED_EVALUATION_MOVE[0];

        if(count($blackArray)=== count($game->getColorList())){

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


    public function getResultViewModel($moveInfo, $game){

        //array con las posiciones que se han cubierto del juego para no tener en cuenta las posiciones repetidas.
        $gamePositionsCoveredArray = array(
            "0" =>false,
            "1" =>false,
            "2" =>false,
            "3" =>false,
            "4" =>false,
            "5" =>false
        );

        //array con las posiciones que se han cubierto del movimiento para no tener en cuenta las posiciones repetidas.
        $movePositionsCoveredArray = array(
            "0" =>false,
            "1" =>false,
            "2" =>false,
            "3" =>false,
            "4" =>false,
            "5" =>false
        );

        $whiteArray = array();
        $blackArray = array();

        //realizamos split del movimiento introducido por el usuario
        $moveInfoArray = explode(',', $moveInfo);

        //obtenemos el array de elementos generado para el juego.
        $gameMoveArray = $game->getColorList();

        //primero buscamos las posiciones negras con el mismo indice para el array de movimiento y el del juego
        for ($k = 0; $k < count($moveInfoArray); $k++) {
            if ($moveInfoArray[$k] == $gameMoveArray[$k]) {
                array_push($blackArray, "X");
                $gamePositionsCoveredArray[$k] = true;
                $movePositionsCoveredArray[$k] = true;
            }
        }

        //recorremos toda la lista y comprobamos que el color existe en otra posición (ficha blanca)
        for ($j = 0; $j <  count($gameMoveArray); $j++) {

            for ($i = 0; $i < count($moveInfoArray); $i++) {

                if($gamePositionsCoveredArray[$j] == false and $movePositionsCoveredArray[$i] == false){ 
                    //si los arrays auxiliares no tienen todavía marcada esa posición como cubierta, comprobamos

                    if ($moveInfoArray[$i] == $gameMoveArray[$j]) {

                        array_push($whiteArray, "X");

                        $gamePositionsCoveredArray[$j] = true;
                        $movePositionsCoveredArray[$i] = true;

                        break;
                    }

                }

            }
        }

        $resultViewModel = new ResultViewModel(); 
        $resultViewModel->setBlackArray($blackArray);
        $resultViewModel->setWhiteArray($whiteArray);

        return $resultViewModel;

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