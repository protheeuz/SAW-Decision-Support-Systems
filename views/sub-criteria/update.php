<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubCriteria */
/* @var $criteriaList array */

$this->title = 'Update Sub Criteria: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sub Criterias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sub-criteria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'criteriaList' => $criteriaList,
    ]) ?>

</div>