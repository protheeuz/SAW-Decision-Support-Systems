<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Alternative;
use app\models\Criteria;
use app\models\Evaluation;

class PreferenceController extends Controller
{
    public function actionIndex()
    {
        $alternatives = Alternative::find()->all();
        $criterias = Criteria::find()->all();

        // Get the evaluations
        $evaluations = Evaluation::find()->all();
        $X = [];
        foreach ($evaluations as $evaluation) {
            $X[$evaluation->id_alternative][$evaluation->id_criteria] = $evaluation->value;
        }

        // Calculate normalized values
        $R = [];
        foreach ($alternatives as $alternative) {
            foreach ($criterias as $criteria) {
                $value = $X[$alternative->id_alternative][$criteria->id_criteria] ?? null;
                if ($value !== null) {
                    if ($criteria->attribute == 'benefit') {
                        $maxValue = max(array_column(array_filter($X, function($v) use ($criteria) { return isset($v[$criteria->id_criteria]); }), $criteria->id_criteria));
                        $R[$alternative->id_alternative][$criteria->id_criteria] = $value / ($maxValue ?: 1);
                    } else {
                        $minValue = min(array_column(array_filter($X, function($v) use ($criteria) { return isset($v[$criteria->id_criteria]); }), $criteria->id_criteria));
                        $R[$alternative->id_alternative][$criteria->id_criteria] = ($minValue ?: 1) / ($value ?: 1);
                    }
                }
            }
        }

        // Calculate preference values
        $P = [];
        $W = array_column($criterias, 'weight', 'id_criteria');
        foreach ($alternatives as $alternative) {
            $hasCompleteEvaluations = true;
            foreach ($criterias as $criteria) {
                if (!isset($R[$alternative->id_alternative][$criteria->id_criteria])) {
                    $hasCompleteEvaluations = false;
                    break;
                }
            }
            if ($hasCompleteEvaluations) {
                $P[$alternative->id_alternative] = 0;
                foreach ($criterias as $criteria) {
                    $P[$alternative->id_alternative] += $W[$criteria->id_criteria] * $R[$alternative->id_alternative][$criteria->id_criteria];
                }
            }
        }

        return $this->render('index', [
            'alternatives' => $alternatives,
            'P' => $P,
            'R' => $R,
            'W' => $W,
        ]);
    }
}