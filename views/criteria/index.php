<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $criterias app\models\Criteria[] */

$this->title = 'Criteria';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Criteria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Criteria</th>
            <th>Weight</th>
            <th>Attribute</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($criterias as $index => $criteria): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= Html::encode($criteria->criteria) ?></td>
            <td><?= Html::encode($criteria->weight) ?></td>
            <td><?= Html::encode($criteria->attribute) ?></td>
            <td>
                <?= Html::a('Edit', ['update', 'id' => $criteria->id_criteria], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $criteria->id_criteria], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>