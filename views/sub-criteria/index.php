<?php

// index.php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $criterias app\models\Criteria[] */
/* @var $groupedSubCriterias array */

$this->title = 'Sub Criteria';
$this->params['breadcrumbs'][] = $this->title;

BootstrapAsset::register($this);

if (Yii::$app->session->hasFlash('error')) {
    $this->registerJs('$("#errorModal").modal("show");');
}
?>
<div class="sub-criteria-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sub Criteria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Jenis Kriteria</th>
                <th>Bobot Kriteria</th>
                <th>Target</th>
                <th>Bobot HR</th>
                <th>Bobot PMO</th>
                <th>Bobot Director</th>
                <th>Total Bobot</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($criterias as $criteria): ?>
                <tr>
                    <td colspan="9" style="background-color: #f0f0f0; font-weight: bold;">
                        <?= Html::encode($criteria->criteria) ?>
                    </td>
                </tr>
                <?php if (isset($groupedSubCriterias[$criteria->id_criteria])): ?>
                    <?php foreach ($groupedSubCriterias[$criteria->id_criteria] as $subCriteria): ?>
                        <tr>
                            <td></td>
                            <td><?= Html::encode($subCriteria->name) ?></td>
                            <td><?= Html::encode($criteria->weight) ?></td>
                            <td><?= Html::encode($criteria->target) ?></td>
                            <td><?= Html::encode($subCriteria->weight_hr) ?></td>
                            <td><?= Html::encode($subCriteria->weight_pmo) ?></td>
                            <td><?= Html::encode($subCriteria->weight_pd) ?></td>
                            <td>
                                <?php if (!is_null($subCriteria->weight_pd)): ?>
                                    <?= Html::encode($criteria->weight * $subCriteria->weight_pd) ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= Html::a('<i class="bi bi-eye"></i>', ['view', 'id' => $subCriteria->id], ['title' => 'View']) ?>
                                <?= Html::a('<i class="bi bi-pencil"></i>', ['update', 'id' => $subCriteria->id], ['title' => 'Update']) ?>
                                <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $subCriteria->id], [
                                    'title' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td></td>
                        <td colspan="8">No sub-criteria found for this criteria.</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php
Modal::begin([
    'id' => 'errorModal',
    'title' => '<h4>Error</h4>',
    'footer' => Html::button('Close', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']),
]);

echo Yii::$app->session->getFlash('error');

Modal::end();
?>