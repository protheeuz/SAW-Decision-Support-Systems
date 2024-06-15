<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Criteria;
use yii\web\NotFoundHttpException;

class CriteriaController extends Controller
{
    public function actionIndex()
    {
        $criterias = Criteria::find()->all();
        return $this->render('index', ['criterias' => $criterias]);
    }

    public function actionCreate()
    {
        $model = new Criteria();

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
        if (($model = Criteria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}