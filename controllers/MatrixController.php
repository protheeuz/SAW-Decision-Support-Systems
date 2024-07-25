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
        $currentYear = Yii::$app->request->get('year', date('Y'));
        $years = Evaluation::find()->select('year')->distinct()->orderBy('year')->column();

        $alternatives = Alternative::find()->all();
        $criterias = Criteria::find()->all();
        $allEvaluations = Evaluation::find()->asArray()->all();

        $maxValues = [];
        $minValues = [];

        foreach ($criterias as $criteria) {
            $values = array_column(array_filter($allEvaluations, function ($evaluation) use ($criteria) {
                return $evaluation['id_criteria'] == $criteria->id_criteria;
            }), 'value');

            $maxValues[$criteria->id_criteria] = !empty($values) ? max($values) : 0;
            $minValues[$criteria->id_criteria] = !empty($values) ? min($values) : 0;
        }

        return $this->render('index', [
            'alternatives' => $alternatives,
            'criterias' => $criterias,
            'allEvaluations' => $allEvaluations,
            'maxValues' => $maxValues,
            'minValues' => $minValues,
        ]);
    }

    public function actionSave()
    {
        $post = Yii::$app->request->post('Evaluation');
        $existingEvaluation = Evaluation::findOne(['id_alternative' => $post['id_alternative'], 'id_criteria' => $post['id_criteria'], 'year' => $post['year']]);
    
        if ($existingEvaluation) {
            Yii::$app->session->setFlash('warning', 'Nilai untuk alternatif, kriteria, dan tahun ini sudah ada.');
        } else {
            $model = new Evaluation();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Nilai berhasil disimpan.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menyimpan nilai.');
            }
        }
    
        return $this->redirect(['index']);
    }

    public function actionDelete($id_alternative, $id_criteria, $year)
    {
        try {
            $deletedCount = Evaluation::deleteAll(['id_alternative' => $id_alternative, 'id_criteria' => $id_criteria, 'year' => $year]);
            if ($deletedCount > 0) {
                Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menghapus data. Data tidak ditemukan atau sudah dihapus sebelumnya.');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Gagal menghapus data. Error: ' . $e->getMessage());
            Yii::error('Delete action failed. Error: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }
}
