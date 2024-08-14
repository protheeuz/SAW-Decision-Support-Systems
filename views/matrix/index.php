<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Matrix';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-heading">
    <h3><?= Html::encode($this->title) ?></h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Metriks Keputusan (X) & Ternormalisasi (R)</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p class="card-text">
                            Melakukan perhitungan normalisasi untuk mendapatkan matriks nilai ternormalisasi (R), dengan ketentuan:
                            Untuk normalisasi nilai, jika faktor/attribute kriteria bertipe cost maka digunakan rumusan:
                            Rij = ( min{Xij} / Xij )
                            sedangkan jika faktor/attribute kriteria bertipe benefit maka digunakan rumusan:
                            Rij = ( Xij / max{Xij} )
                        </p>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm m-2" data-bs-toggle="modal" data-bs-target="#inlineForm">
                        Isi Nilai Alternatif
                    </button>
                    <div class="table-responsive">
                        <?php for ($year = 2019; $year <= date('Y'); $year++): ?>
                            <?php
                            $evaluations = array_filter($allEvaluations, function($evaluation) use ($year) {
                                return $evaluation['year'] == $year;
                            });
                            ?>
                            <?php if (!empty($evaluations)): ?>
                                <h4>Penilaian Pada: <?= $year ?></h4>
                                <table class="table table-striped mb-0 table-full-width">
                                    <caption>Matrik Keputusan(X) Tahun <?= Html::encode($year) ?></caption>
                                    <tr>
                                        <th rowspan="2">Alternatif</th>
                                        <th colspan="<?= count($criterias) ?>">Kriteria</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($criterias as $index => $criteria): ?>
                                            <th>C<?= $index + 1 ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php
                                    $X = [];
                                    foreach ($evaluations as $evaluation) {
                                        $X[$evaluation['id_criteria']][$evaluation['id_alternative']] = $evaluation['value'];
                                    }
                                    foreach ($alternatives as $alternative):
                                        ?>
                                        <tr>
                                            <th>A<?= Html::encode($alternative->id_alternative) ?> <?= Html::encode($alternative->name) ?></th>
                                            <?php foreach ($criterias as $criteria): ?>
                                                <td><?= Html::encode($X[$criteria->id_criteria][$alternative->id_alternative] ?? '-') ?></td>
                                            <?php endforeach; ?>
                                            <td>
                                                <?= Html::a('Edit', ['matrix/edit', 'id_alternative' => $alternative->id_alternative, 'year' => $year], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <table class="table table-striped mb-0 table-full-width">
                                    <caption>Matrik Ternormalisasi (R) Tahun <?= Html::encode($year) ?></caption>
                                    <tr>
                                        <th rowspan="2">Alternatif</th>
                                        <th colspan="<?= count($criterias) ?>">Kriteria</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($criterias as $index => $criteria): ?>
                                            <th>C<?= $index + 1 ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php
                                    foreach ($alternatives as $alternative):
                                        ?>
                                        <tr>
                                            <th>A<?= Html::encode($alternative->id_alternative) ?> <?= Html::encode($alternative->name) ?></th>
                                            <?php
                                            $normalized = [];
                                            foreach ($criterias as $criteria) {
                                                $value = $X[$criteria->id_criteria][$alternative->id_alternative] ?? 0;
                                                if ($criteria->attribute == 'benefit') {
                                                    $normalized[$criteria->id_criteria] = $value / ($maxValues[$criteria->id_criteria] ?: 1);
                                                } else {
                                                    $normalized[$criteria->id_criteria] = ($minValues[$criteria->id_criteria] ?: 1) / ($value ?: 1);
                                                }
                                            }
                                            ?>
                                            <?php foreach ($criterias as $criteria): ?>
                                                <td><?= Html::encode(round($normalized[$criteria->id_criteria], 2)) ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Isi Nilai Alternatif -->
<div class="modal fade" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="inlineFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inlineFormLabel">Isi Nilai Alternatif</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin(['action' => Url::to(['matrix/save'])]); ?>
            <div class="modal-body">
                <?= $form->field(new \app\models\Evaluation(), 'id_alternative')->dropDownList(
                    \yii\helpers\ArrayHelper::map($alternatives, 'id_alternative', 'name'),
                    ['prompt' => 'Pilih Alternatif']
                ) ?>
                <?= $form->field(new \app\models\Evaluation(), 'id_criteria')->dropDownList(
                    \yii\helpers\ArrayHelper::map($criterias, 'id_criteria', 'criteria'),
                    ['prompt' => 'Pilih Kriteria']
                ) ?>
                <?= $form->field(new \app\models\Evaluation(), 'value')->textInput(['placeholder' => 'Nilai...']) ?>
                <?= $form->field(new \app\models\Evaluation(), 'year')->dropDownList(
                    array_combine(range(2019, date('Y')), range(2019, date('Y'))),
                    ['prompt' => 'Pilih Tahun']
                ) ?>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/assets/js/bootstrap.bundle.min.js') ?>
</body>
</html>