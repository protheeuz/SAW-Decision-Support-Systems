<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Alternative;
use app\models\Criteria;
use app\models\Evaluation;
use yii\web\NotFoundHttpException;

class MatrixController extends Controller
{
    public function actionIndex()
    {
        $alternatives = Alternative::find()->all();
        $criterias = Criteria::find()->all();
        $evaluations = Evaluation::find()
            ->select(['id_alternative', 'id_criteria', 'value'])
            ->orderBy('id_alternative')
            ->asArray()
            ->all();

        $maxValues = [];
        $minValues = [];
        foreach ($criterias as $criteria) {
            $values = array_column(array_filter($evaluations, fn($e) => $e['id_criteria'] == $criteria->id_criteria), 'value');
            $maxValues[$criteria->id_criteria] = !empty($values) ? max($values) : 1;
            $minValues[$criteria->id_criteria] = !empty($values) ? min($values) : 1;
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
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id_alternative, $id_criteria)
    {
        Yii::info('Deleting evaluation with id_alternative: ' . $id_alternative . ' and id_criteria: ' . $id_criteria, __METHOD__);
    
        $model = Evaluation::findOne(['id_alternative' => $id_alternative, 'id_criteria' => $id_criteria]);
    
        if ($model !== null) {
            Yii::info('Model found. Proceeding to delete.', __METHOD__);
            $model->delete();
            Yii::info('Model deleted successfully.', __METHOD__);
        } else {
            Yii::warning('Model not found for deletion.', __METHOD__);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    
        return $this->redirect(['index']);
    }
}