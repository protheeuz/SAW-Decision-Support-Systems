<?php

use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $alternatives app\models\Alternative[] */
/* @var $P array */
/* @var $years array */

$this->title = 'Nilai Preferensi';
$this->params['breadcrumbs'][] = $this->title;

// Fungsi untuk membuat data provider untuk pagination
function createDataProvider($alternatives, $P, $year) {
    $preferenceData = [];
    foreach ($alternatives as $alternative) {
        if (isset($P[$year][$alternative->id_alternative]) && $P[$year][$alternative->id_alternative] != 0) {
            $preferenceData[] = [
                'id' => $alternative->id_alternative,
                'name' => $alternative->name,
                'value' => round($P[$year][$alternative->id_alternative], 2)
            ];
        }
    }

    // Mengurutkan data preferensi dari nilai tertinggi ke terendah
    usort($preferenceData, function($a, $b) {
        return $b['value'] <=> $a['value'];
    });

    return new ArrayDataProvider([
        'allModels' => $preferenceData,
        'pagination' => [
            'pageSize' => 5,
        ],
    ]);
}

?>

<div class="page-heading">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <?php foreach ($years as $year): ?>
                <?php $dataProvider = createDataProvider($alternatives, $P, $year); ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Tabel Nilai Preferensi (P) Tahun <?= Html::encode($year) ?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">
                                Nilai preferensi (P) merupakan penjumlahan dari perkalian matriks ternormalisasi R dengan vektor bobot W.
                            </p>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <caption>Nilai Preferensi (P) Tahun <?= Html::encode($year) ?></caption>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        <th>Hasil</th>
                                    </tr>
                                    <?php
                                    $no = 1;
                                    foreach ($alternatives as $alternative):
                                        if (!isset($P[$year][$alternative->id_alternative]) || $P[$year][$alternative->id_alternative] == 0) continue;
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= Html::encode($alternative->name) ?></td>
                                        <td><?= Html::encode(round($P[$year][$alternative->id_alternative], 2)) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Tabel Perangkingan Tahun <?= Html::encode($year) ?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <caption>Ranking Alternatif Tahun <?= Html::encode($year) ?></caption>
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
                                <?= LinkPager::widget([
                                    'pagination' => $dataProvider->pagination,
                                    'options' => ['class' => 'pagination justify-content-center'],
                                    'linkContainerOptions' => ['class' => 'page-item'],
                                    'linkOptions' => ['class' => 'page-link'],
                                    'activePageCssClass' => 'active',
                                    'disabledPageCssClass' => 'disabled',
                                    'prevPageLabel' => '&laquo;',
                                    'nextPageLabel' => '&raquo;',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Keterangan Nilai</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <ul>
                            <li><strong>350 - 425:</strong> Sangat Baik</li>
                            <li><strong>275 - 350:</strong> Baik</li>
                            <li><strong>200 - 275:</strong> Kurang Baik</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>