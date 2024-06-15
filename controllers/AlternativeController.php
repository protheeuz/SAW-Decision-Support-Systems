<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Alternative;
use yii\web\NotFoundHttpException;

class AlternativeController extends Controller
{
    public function actionIndex()
    {
        $alternatives = Alternative::find()->all();
        return $this->render('index', ['alternatives' => $alternatives]);
    }

    public function actionCreate()
    {
        $model = new Alternative();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Alternative::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
