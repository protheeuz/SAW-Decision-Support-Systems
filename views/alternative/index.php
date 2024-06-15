<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $alternatives app\models\Alternative[] */

$this->title = 'Alternatives';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alternative-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Alternative', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($alternatives as $index => $alternative): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= Html::encode($alternative->name) ?></td>
            <td>
                <?= Html::a('Edit', ['update', 'id' => $alternative->id_alternative], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $alternative->id_alternative], [
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