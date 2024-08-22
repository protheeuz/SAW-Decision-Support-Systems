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
        // Dapatkan daftar tahun dari data evaluasi
        $years = Evaluation::find()->select('year')->distinct()->column();

        $alternatives = Alternative::find()->all();
        $criterias = Criteria::find()->all();

        // Get the evaluations for all years
        $evaluations = Evaluation::find()->all();
        $X = [];
        foreach ($evaluations as $evaluation) {
            $X[$evaluation->year][$evaluation->id_alternative][$evaluation->id_criteria] = $evaluation->value;
        }

        // Calculate normalized values
        $R = [];
        $maxValues = [];
        $minValues = [];

        foreach ($criterias as $criteria) {
            foreach ($years as $year) {
                $values = array_column(array_filter($evaluations, function ($v) use ($criteria, $year) {
                    return isset($v['id_criteria'], $v['year']) && $v['id_criteria'] == $criteria->id_criteria && $v['year'] == $year;
                }), 'value');

                $maxValues[$year][$criteria->id_criteria] = !empty($values) ? max($values) : 1;
                $minValues[$year][$criteria->id_criteria] = !empty($values) ? min($values) : 1;
            }
        }

        foreach ($alternatives as $alternative) {
            foreach ($years as $year) {
                foreach ($criterias as $criteria) {
                    $value = $X[$year][$alternative->id_alternative][$criteria->id_criteria] ?? 0;
                    if ($criteria->attribute == 'benefit') {
                        $R[$year][$alternative->id_alternative][$criteria->id_criteria] = $value / ($maxValues[$year][$criteria->id_criteria] ?: 1);
                    } else {
                        $R[$year][$alternative->id_alternative][$criteria->id_criteria] = ($minValues[$year][$criteria->id_criteria] ?: 1) / ($value ?: 1);
                    }
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
            foreach ($years as $year) {
                $P[$year][$alternative->id_alternative] = 0;
                foreach ($criterias as $criteria) {
                    if (isset($R[$year][$alternative->id_alternative][$criteria->id_criteria])) {
                        $subCriterias = SubCriteria::find()->where(['id_criteria' => $criteria->id_criteria])->all();
                        foreach ($subCriterias as $subCriteria) {
                            $weightedSubCriteria = $criteria->weight * $subCriteria->weight_pd;
                            $P[$year][$alternative->id_alternative] += $weightedSubCriteria * $R[$year][$alternative->id_alternative][$criteria->id_criteria];
                        }
                    }
                }
            }
        }

        return $this->render('index', [
            'alternatives' => $alternatives,
            'P' => $P,
            'years' => $years,
        ]);
    }

    private function getPreferenceLabel($value)
    {
        if ($value >= 350) {
            return 'Sangat Baik';
        } elseif ($value >= 275) {
            return 'Baik';
        } elseif ($value >= 200) {
            return 'Kurang Baik';
        } else {
            return 'Tidak Memadai';
        }
    }
}