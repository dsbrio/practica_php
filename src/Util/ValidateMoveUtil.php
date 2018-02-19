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













        $move = new Move();
        $move->setMasterMindGame($game);
        $move->setDate(new \DateTime());
        $move->setColorList(
            str_split($moveInfo)
        );

        //TODO set correct evaluation
        $move->setEvaluation(ValidateMoveUtil::DEFINED_EVALUATION_MOVE[0]);

        $evaluationModel->setMove($move);
        return $evaluationModel;
    }


}