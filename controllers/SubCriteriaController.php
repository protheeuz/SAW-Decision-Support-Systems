<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SubCriteria;
use app\models\Criteria;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class SubCriteriaController extends Controller
{
    public function actionIndex()
    {
        $criterias = Criteria::find()->all();
        $subCriterias = SubCriteria::find()->all();

        $groupedSubCriterias = [];
        foreach ($subCriterias as $subCriteria) {
            $groupedSubCriterias[$subCriteria->id_criteria][] = $subCriteria;
        }

        return $this->render('index', [
            'criterias' => $criterias,
            'groupedSubCriterias' => $groupedSubCriterias,
        ]);
    }

    public function actionCreate()
    {
        $model = new SubCriteria();
        $criteriaList = Criteria::find()->select(['criteria', 'id_criteria'])->indexBy('id_criteria')->column();
        $subCriteriaList = [];

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->user->identity->role == 'Manager PMO' || Yii::$app->user->identity->role == 'Project Director') {
                $existingSubCriteria = SubCriteria::findOne($model->id);

                if (!$existingSubCriteria) {
                    Yii::$app->session->setFlash('error', 'Please select a valid sub-criteria.');
                    return $this->redirect(['create']);
                }

                if (Yii::$app->user->identity->role == 'Manager PMO') {
                    if (is_null($existingSubCriteria->weight_hr)) {
                        Yii::$app->session->setFlash('error', 'HR Manager harus mengisi data terlebih dahulu.');
                        return $this->redirect(['index']);
                    }
                    $existingSubCriteria->weight_pmo = $model->weight_pmo;
                } elseif (Yii::$app->user->identity->role == 'Project Director') {
                    if (is_null($existingSubCriteria->weight_pmo)) {
                        Yii::$app->session->setFlash('error', 'Manager PMO harus mengisi data terlebih dahulu.');
                        return $this->redirect(['index']);
                    }
                    $existingSubCriteria->weight_pd = $model->weight_pd;
                }

                if ($existingSubCriteria->save()) {
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save the sub-criteria.');
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'criteriaList' => $criteriaList,
            'subCriteriaList' => $subCriteriaList,
        ]);
    }

    public function actionGetSubCriteria($id_criteria)
    {
        $subCriteriaList = SubCriteria::find()->where(['id_criteria' => $id_criteria])->select(['name', 'id'])->indexBy('id')->column();
        return $this->asJson($subCriteriaList);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $criteriaList = Criteria::find()->select(['criteria', 'id_criteria'])->indexBy('id_criteria')->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'criteriaList' => $criteriaList,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = SubCriteria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
}