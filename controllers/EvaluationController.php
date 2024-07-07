<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Evaluation;
use yii\web\NotFoundHttpException;

class EvaluationController extends Controller
{
    public function actionDelete($id_alternative, $id_criteria)
    {
        Yii::info('Delete action called with id_alternative: ' . $id_alternative . ' and id_criteria: ' . $id_criteria, __METHOD__);

        // Cari data yang akan dihapus
        $model = Evaluation::findOne([
            'id_alternative' => $id_alternative,
            'id_criteria' => $id_criteria,
        ]);

        if ($model !== null) {
            try {
                $model->delete();
                Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'Gagal menghapus data. Error: ' . $e->getMessage());
                Yii::error('Failed to delete data: ' . $e->getMessage(), __METHOD__);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Data tidak ditemukan.');
            Yii::error('Data not found for id_alternative: ' . $id_alternative . ' and id_criteria: ' . $id_criteria, __METHOD__);
        }

        // Redirect kembali ke halaman index atau halaman lain yang sesuai
        return $this->redirect(['matrix/index']);
    }
}