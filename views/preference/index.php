<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $alternatives app\models\Alternative[] */
/* @var $P array */

$this->title = 'Nilai Preferensi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preference-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped mb-0">
        <caption>Nilai Preferensi (P)</caption>
        <tr>
            <th>No</th>
            <th>Alternatif</th>
            <th>Hasil</th>
        </tr>
        <?php foreach ($alternatives as $index => $alternative): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= Html::encode($alternative->name) ?></td>
            <td><?= Html::encode($P[$alternative->id_alternative]) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>