<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Alternative;
use app\models\Criteria;
use app\models\Evaluation;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $totalAlternatives = (new \yii\db\Query())
            ->from('saw_alternatives')
            ->count();

        $totalCriterias = (new \yii\db\Query())
            ->from('saw_criterias')
            ->count();

        $totalSubCriterias = (new \yii\db\Query())
            ->from('saw_sub_criterias')
            ->count();

        $role = Yii::$app->user->identity->role;

        // Mendapatkan data penilaian per tahun
        $chartData = (new \yii\db\Query())
            ->select(['a.name as alternative_name', 'e.year', 'SUM(e.value) as score'])
            ->from('saw_alternatives a')
            ->leftJoin('saw_evaluations e', 'a.id_alternative = e.id_alternative')
            ->groupBy(['a.name', 'e.year'])
            ->orderBy(['e.year' => SORT_ASC])
            ->all();

        // Mendapatkan data penilaian per kriteria
        $criteriaChartData = (new \yii\db\Query())
            ->select(['c.criteria as criteria_name', 'SUM(e.value) as score'])
            ->from('saw_evaluations e')
            ->leftJoin('saw_criterias c', 'e.id_criteria = c.id_criteria')
            ->groupBy('c.criteria')
            ->all();

        return $this->render('index', [
            'totalAlternatives' => $totalAlternatives,
            'totalCriterias' => $totalCriterias,
            'totalSubCriterias' => $totalSubCriterias,
            'role' => $role,
            'chartData' => $chartData,
            'criteriaChartData' => $criteriaChartData,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
                'error' => $model->getFirstError('password'), // Get error message for password field
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    // Mendapatkan data alternatif tertinggi berdasarkan kriteria
    public function actionTopAlternative($criteria)
    {
        $alternatives = (new \yii\db\Query())
            ->select(['a.name as alternative_name', 'e.year', 'SUM(e.value) as score'])
            ->from('saw_evaluations e')
            ->leftJoin('saw_alternatives a', 'e.id_alternative = a.id_alternative')
            ->leftJoin('saw_criterias c', 'e.id_criteria = c.id_criteria')
            ->where(['c.criteria' => $criteria])
            ->groupBy(['a.name', 'e.year'])
            ->orderBy(['a.name' => SORT_ASC, 'e.year' => SORT_ASC])
            ->all();

        return $this->asJson($alternatives);
    }
}
