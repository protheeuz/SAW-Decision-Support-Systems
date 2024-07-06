<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubCriteria */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sub Criterias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-criteria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apa kamu yakin untuk menghapus item ini?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_criteria',
            [
                'attribute' => 'criteria.criteria',
                'label' => 'Kriteria',
            ],
            'name',
            'weight_hr',
            'weight_pmo',
            'weight_pd',
            [
                'attribute' => 'total_weight',
                'label' => 'Total Bobot',
                'value' => function ($model) {
                    return $model->weight_hr + $model->weight_pmo + $model->weight_pd;
                }
            ],
        ],
    ]) ?>

</div>