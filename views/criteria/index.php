<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $criterias app\models\Criteria[] */

$this->title = 'Kriteria';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-heading">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
<div class="page-content">
    <section class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Bobot Kriteria</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p class="card-text">
                            Pengambil keputusan memberi bobot preferensi dari setiap kriteria dengan masing-masing jenisnya (keuntungan/benefit atau biaya/cost):
                        </p>
                        <p>
                            <?= Html::a('Tambah Kriteria', ['create'], ['class' => 'btn btn-success']) ?>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <caption>
                                    Tabel Kriteria C<sub>i</sub>
                                </caption>
                                <tr>
                                    <th>No</th>
                                    <th>Simbol</th>
                                    <th>Kriteria</th>
                                    <th>Bobot</th>
                                    <th>Atribut</th>
                                    <th>Target</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php foreach ($criterias as $index => $criteria): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td class='center'>C<?= $index + 1 ?></td>
                                    <td><?= Html::encode($criteria->criteria) ?></td>
                                    <td><?= Html::encode($criteria->weight) ?></td>
                                    <td><?= Html::encode($criteria->attribute) ?></td>
                                    <td><?= Html::encode($criteria->target) ?></td>
                                    <td>
                                        <?= Html::a('Edit', ['update', 'id' => $criteria->id_criteria], ['class' => 'btn btn-info btn-sm']) ?>
                                        <?= Html::a('Delete', ['delete', 'id' => $criteria->id_criteria], [
                                            'class' => 'btn btn-danger btn-sm',
                                            'data' => [
                                                'confirm' => 'Apa kamu yakin untuk menghapus item ini? ',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>