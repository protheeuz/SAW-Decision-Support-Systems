<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Evaluation;
use yii\web\NotFoundHttpException;

class EvaluationController extends Controller
{
    public function actionDelete($id)
    {
        Evaluation::deleteAll(['id_alternative' => $id]);
        return $this->redirect(['matrix/index']);
    }
}