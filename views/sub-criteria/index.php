<?php

// index.php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $criterias app\models\Criteria[] */
/* @var $groupedSubCriterias array */

$this->title = 'Sub Kriteria';
$this->params['breadcrumbs'][] = $this->title;

BootstrapAsset::register($this);

if (Yii::$app->session->hasFlash('error')) {
    $this->registerJs('$("#errorModal").modal("show");');
}

?>

<div class="sub-criteria-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Sub Kriteria', ['create'], ['class' => 'btn btn-success']) ?>
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
            <?php 
            $totalWeightCriteria = 0;
            $totalWeightCalculated = 0;

            foreach ($criterias as $criteria) :
                // Hitung total bobot kriteria dengan memperhitungkan sub-kriteria
                $numSubCriterias = count($groupedSubCriterias[$criteria->id_criteria] ?? []);
                $totalWeightCriteria += $criteria->weight * $numSubCriterias;
                ?>
                <tr>
                    <td colspan="9" style="background-color: #f0f0f0; font-weight: bold;">
                        <?= Html::encode($criteria->criteria) ?>
                    </td>
                </tr>
                <?php if (isset($groupedSubCriterias[$criteria->id_criteria])) : ?>
                    <?php foreach ($groupedSubCriterias[$criteria->id_criteria] as $subCriteria) :
                        $calculatedWeight = !is_null($subCriteria->weight_pd) ? $criteria->weight * $subCriteria->weight_pd : 0;
                        $totalWeightCalculated += $calculatedWeight;
                    ?>
                        <tr>
                            <td></td>
                            <td><?= Html::encode($subCriteria->name) ?></td>
                            <td><?= Html::encode($criteria->weight) ?></td>
                            <td><?= Html::encode($criteria->target) ?></td>
                            <td><?= Html::encode($subCriteria->weight_hr) ?></td>
                            <td><?= Html::encode($subCriteria->weight_pmo) ?></td>
                            <td><?= Html::encode($subCriteria->weight_pd) ?></td>
                            <td>
                                <?= Html::encode($calculatedWeight) ?>
                            </td>
                            <td>
                                <?= Html::a('<i class="bi bi-eye"></i>', ['view', 'id' => $subCriteria->id], ['title' => 'View']) ?>
                                <?= Html::a('<i class="bi bi-pencil"></i>', ['update', 'id' => $subCriteria->id], ['title' => 'Update']) ?>
                                <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $subCriteria->id], [
                                    'title' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Apa kamu yakin untuk menghapus item ini?',
                                        'method' => 'post',
                                        'params' => [
                                            Yii::$app->request->csrfParam => Yii::$app->request->csrfToken,
                                        ],
                                    ],
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td></td>
                        <td colspan="8">No sub-criteria found for this criteria.</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="font-weight: bold;">Total</td>
                <td><?= Html::encode($totalWeightCriteria) ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?= Html::encode($totalWeightCalculated) ?></td>
                <td></td>
            </tr>
        </tfoot>
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