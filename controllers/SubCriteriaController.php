<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SubCriteria;
use app\models\Criteria;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        $existingSubCriteria = null;

        if (Yii::$app->user->identity->role == 'Manager PMO' || Yii::$app->user->identity->role == 'Project Director') {
            $post = Yii::$app->request->post('SubCriteria');
            if (isset($post['id_criteria'])) {
                $id_criteria = $post['id_criteria'];
                $subCriteriaList = SubCriteria::find()
                    ->select(['name', 'id'])
                    ->where(['id_criteria' => $id_criteria])
                    ->indexBy('id')
                    ->column();

                if (isset($post['id'])) {
                    $id = $post['id'];
                    $existingSubCriteria = SubCriteria::find()
                        ->where(['id_criteria' => $id_criteria, 'id' => $id])
                        ->one();
                }
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            // Log data dari database
            Yii::error('Post data: ' . json_encode(Yii::$app->request->post()));
            Yii::error('Existing SubCriteria: ' . json_encode($existingSubCriteria));

            if (Yii::$app->user->identity->role == 'Manager PMO' || Yii::$app->user->identity->role == 'Project Director') {
                if ($existingSubCriteria) {
                    if (Yii::$app->user->identity->role == 'Manager PMO') {
                        if ($existingSubCriteria->weight_hr === null || $existingSubCriteria->weight_hr == 0) {
                            Yii::$app->session->setFlash('error', 'HR Manager harus mengisi data terlebih dahulu.');
                            return $this->redirect(['index']);
                        }
                        $existingSubCriteria->weight_pmo = $model->weight_pmo;
                    } elseif (Yii::$app->user->identity->role == 'Project Director') {
                        if ($existingSubCriteria->weight_pmo === null || $existingSubCriteria->weight_pmo == 0) {
                            Yii::$app->session->setFlash('error', 'Manager PMO harus mengisi data terlebih dahulu.');
                            return $this->redirect(['index']);
                        }
                        $existingSubCriteria->weight_pd = $model->weight_pd;
                    }
                    if ($existingSubCriteria->save()) {
                        return $this->redirect(['index']);
                    } else {
                        Yii::error('Data gagal diperbarui: ' . json_encode($existingSubCriteria->errors));
                        Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat memperbarui data.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'HR Manager harus mengisi data terlebih dahulu.');
                    return $this->redirect(['index']);
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(['index']);
                } else {
                    Yii::error('Data gagal disimpan: ' . json_encode($model->errors));
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data.');
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
        Yii::$app->response->format = Response::FORMAT_JSON;
        $subCriteriaList = SubCriteria::find()
            ->select(['name', 'id'])
            ->where(['id_criteria' => $id_criteria])
            ->indexBy('id')
            ->column();

        return $subCriteriaList;
    }

    public function actionGetSubCriteriaName($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $subCriteria = SubCriteria::findOne($id);
        return ['id' => $subCriteria ? $subCriteria->id : null];
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

        $subCriteriaList = [];
        if ($model->id_criteria) {
            $subCriteriaList = SubCriteria::find()
                ->select(['name', 'id'])
                ->where(['id_criteria' => $model->id_criteria])
                ->indexBy('id')
                ->column();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'criteriaList' => $criteriaList,
            'subCriteriaList' => $subCriteriaList,
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
