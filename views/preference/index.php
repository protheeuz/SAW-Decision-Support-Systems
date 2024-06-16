<?php

use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $alternatives app\models\Alternative[] */
/* @var $P array */

$this->title = 'Nilai Preferensi';
$this->params['breadcrumbs'][] = $this->title;

// Membuat data provider untuk pagination
$preferenceData = [];
foreach ($alternatives as $alternative) {
    if (isset($P[$alternative->id_alternative]) && $P[$alternative->id_alternative] != 0) {
        $preferenceData[] = [
            'id' => $alternative->id_alternative,
            'name' => $alternative->name,
            'value' => round($P[$alternative->id_alternative], 2)
        ];
    }
}

// Mengurutkan data preferensi dari nilai tertinggi ke terendah
usort($preferenceData, function($a, $b) {
    return $b['value'] <=> $a['value'];
});

$dataProvider = new ArrayDataProvider([
    'allModels' => $preferenceData,
    'pagination' => [
        'pageSize' => 5,
    ],
]);

?>

<div class="page-heading">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Nilai Preferensi (P)</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p class="card-text">
                            Nilai preferensi (P) merupakan penjumlahan dari perkalian matriks ternormalisasi R dengan vektor bobot W.
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <caption>Nilai Preferensi (P)</caption>
                                <tr>
                                    <th>No</th>
                                    <th>Alternatif</th>
                                    <th>Hasil</th>
                                </tr>
                                <?php
                                $no = 1;
                                foreach ($alternatives as $alternative):
                                    if (!isset($P[$alternative->id_alternative]) || $P[$alternative->id_alternative] == 0) continue;
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= Html::encode($alternative->name) ?></td>
                                    <td><?= Html::encode(round($P[$alternative->id_alternative], 2)) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Perangkingan</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <caption>Ranking Alternatif</caption>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Nilai Preferensi</th>
                                        <th>Ranking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $page = $dataProvider->pagination->page;
                                    $pageSize = $dataProvider->pagination->pageSize;
                                    $rank = $page * $pageSize + 1;
                                    foreach ($dataProvider->models as $index => $item): ?>
                                    <tr>
                                        <td><?= ($page * $pageSize) + $index + 1 ?></td>
                                        <td><?= Html::encode($item['name']) ?></td>
                                        <td><?= Html::encode($item['value']) ?></td>
                                        <td><?= $rank++ ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper">
                            <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>