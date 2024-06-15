<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Evaluation;
use app\models\Alternative;
use app\models\Criteria;

class MatrixController extends Controller
{
    public function actionIndex()
    {
        $alternatives = Alternative::find()->all();
        $criterias = Criteria::find()->all();

        // Fetch evaluations and prepare data for views
        $evaluations = Evaluation::find()
            ->select(['id_alternative', 'id_criteria', 'value'])
            ->orderBy('id_alternative')
            ->asArray()
            ->all();

        return $this->render('index', [
            'alternatives' => $alternatives,
            'criterias' => $criterias,
            'evaluations' => $evaluations,
        ]);
    }

    public function actionSave()
    {
        $id_alternative = Yii::$app->request->post('id_alternative');
        $id_criteria = Yii::$app->request->post('id_criteria');
        $value = Yii::$app->request->post('value');

        $evaluation = new Evaluation();
        $evaluation->id_alternative = $id_alternative;
        $evaluation->id_criteria = $id_criteria;
        $evaluation->value = $value;

        if ($evaluation->save()) {
            return $this->redirect(['matrix/index']);
        } else {
            return "Error: " . implode(", ", $evaluation->errors);
        }
    }
}
