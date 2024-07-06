<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Alternative;
use app\models\Criteria;
use app\models\Evaluation;
use app\models\SubCriteria;

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
        $maxValues = [];
        $minValues = [];

        foreach ($criterias as $criteria) {
            $values = array_column(array_filter($evaluations, function ($v) use ($criteria) {
                return isset($v['id_criteria']) && $v['id_criteria'] == $criteria->id_criteria;
            }), 'value');

            $maxValues[$criteria->id_criteria] = !empty($values) ? max($values) : 1;
            $minValues[$criteria->id_criteria] = !empty($values) ? min($values) : 1;
        }

        foreach ($alternatives as $alternative) {
            foreach ($criterias as $criteria) {
                $value = $X[$alternative->id_alternative][$criteria->id_criteria] ?? 0;
                if ($criteria->attribute == 'benefit') {
                    $R[$alternative->id_alternative][$criteria->id_criteria] = $value / ($maxValues[$criteria->id_criteria] ?: 1);
                } else {
                    $R[$alternative->id_alternative][$criteria->id_criteria] = ($minValues[$criteria->id_criteria] ?: 1) / ($value ?: 1);
                }
            }
        }

        // Calculate total weight dynamically from sub-criteria weighted by Project Director
        $totalWeight = 0;
        foreach ($criterias as $criteria) {
            $subCriterias = SubCriteria::find()->where(['id_criteria' => $criteria->id_criteria])->all();
            foreach ($subCriterias as $subCriteria) {
                $totalWeight += $criteria->weight * $subCriteria->weight_pd;
            }
        }

        // Calculate preference values
        $P = [];
        foreach ($alternatives as $alternative) {
            $P[$alternative->id_alternative] = 0;
            foreach ($criterias as $criteria) {
                if (isset($R[$alternative->id_alternative][$criteria->id_criteria])) {
                    $subCriterias = SubCriteria::find()->where(['id_criteria' => $criteria->id_criteria])->all();
                    foreach ($subCriterias as $subCriteria) {
                        $weightedSubCriteria = $criteria->weight * $subCriteria->weight_pd;
                        $P[$alternative->id_alternative] += $weightedSubCriteria * $R[$alternative->id_alternative][$criteria->id_criteria];
                    }
                }
            }
        }

        return $this->render('index', [
            'alternatives' => $alternatives,
            'P' => $P,
            'R' => $R,
        ]);
    }
}