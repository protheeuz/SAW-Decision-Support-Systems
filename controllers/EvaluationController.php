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
        // Cari data yang akan dihapus
        $model = Evaluation::findOne([
            'id_alternative' => $id_alternative,
            'id_criteria' => $id_criteria,
        ]);
    
        // Hapus data jika ditemukan
        if ($model) {
            $model->delete();
        }
    
        // Redirect kembali ke halaman index
        return $this->redirect(['index']);
    }
    
}