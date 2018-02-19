<?php


namespace App\Util;

use App\Entity\Move;
use App\Model\EvaluationModel;


class ValidateMoveUtil
{

    public function  validateMove($moveInfo){

        $evaluationModel = new EvaluationModel();



        //TODO




        $evaluationModel->setEvaluation(Move::DEFINED_EVALUATION_MOVE[0]);

        return $evaluationModel;
    }


}