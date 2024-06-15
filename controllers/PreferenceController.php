<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Criteria;
use app\models\Evaluation;
use app\models\Alternative;

class PreferenceController extends Controller
{
    public function actionIndex()
    {
        // Fetch data
        $criterias = Criteria::find()->all();
        $alternatives = Alternative::find()->all();
        $evaluations = Evaluation::find()
            ->select(['id_alternative', 'id_criteria', 'value'])
            ->orderBy('id_alternative')
            ->asArray()
            ->all();

        // Calculate weights
        $W = array_map(function ($criteria) {
            return $criteria->weight;
        }, $criterias);

        // Calculate normalized matrix
        $X = [];
        foreach ($evaluations as $evaluation) {
            $X[$evaluation['id_alternative']][$evaluation['id_criteria']] = $evaluation['value'];
        }

        // Calculate preference values
        $P = [];
        foreach ($alternatives as $alternative) {
            $P[$alternative->id_alternative] = 0;
            foreach ($criterias as $criteria) {
                $value = $X[$alternative->id_alternative][$criteria->id_criteria] ?? 0;
                $P[$alternative->id_alternative] += $value * $criteria->weight;
            }
        }

        return $this->render('index', [
            'alternatives' => $alternatives,
            'P' => $P,
        ]);
    }
}