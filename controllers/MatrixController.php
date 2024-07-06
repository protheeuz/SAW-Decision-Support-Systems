<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Alternative;
use app\models\Criteria;
use app\models\Evaluation;

class MatrixController extends Controller
{
    public function actionIndex()
    {
        $alternatives = Alternative::find()->all();
        $criterias = Criteria::find()->all();
        $evaluations = Evaluation::find()->asArray()->all();

        $maxValues = [];
        $minValues = [];

        foreach ($criterias as $criteria) {
            $values = array_column(array_filter($evaluations, function ($evaluation) use ($criteria) {
                return $evaluation['id_criteria'] == $criteria->id_criteria;
            }), 'value');

            $maxValues[$criteria->id_criteria] = !empty($values) ? max($values) : 0;
            $minValues[$criteria->id_criteria] = !empty($values) ? min($values) : 0;
        }

        return $this->render('index', [
            'alternatives' => $alternatives,
            'criterias' => $criterias,
            'evaluations' => $evaluations,
            'maxValues' => $maxValues,
            'minValues' => $minValues,
        ]);
    }

    public function actionSave()
    {
        $model = new Evaluation();
        $post = Yii::$app->request->post('Evaluation');

        if ($post) {
            $existingEvaluation = Evaluation::findOne(['id_alternative' => $post['id_alternative'], 'id_criteria' => $post['id_criteria']]);
            if ($existingEvaluation) {
                Yii::$app->session->setFlash('warning', 'Nilai untuk alternatif dan kriteria ini sudah ada.');
            } else {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Nilai berhasil disimpan.');
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan nilai.');
                }
            }
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($id_alternative, $id_criteria)
    {
        Evaluation::deleteAll(['id_alternative' => $id_alternative, 'id_criteria' => $id_criteria]);
        Yii::$app->session->setFlash('success', 'Nilai berhasil dihapus.');
        return $this->redirect(['index']);
    }
}
