<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit Nilai Alternatif';
$this->params['breadcrumbs'][] = ['label' => 'Matrix', 'url' => ['index']];
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
                    <h4 class="card-title">Edit Nilai Alternatif Tahun <?= Html::encode($year) ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(); ?>
                        <table class="table table-striped mb-0 table-full-width">
                            <tr>
                                <th>Kriteria</th>
                                <th>Nilai</th>
                            </tr>
                            <?php foreach ($evaluations as $evaluation): ?>
                                <tr>
                                    <td><?= Html::encode($evaluation->criteria->criteria) ?></td> <!-- Akses relasi criteria -->
                                    <td>
                                        <?= Html::input('text', "Evaluation[{$evaluation->id_criteria}]", $evaluation->value, ['class' => 'form-control']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                        <div class="form-group mt-3">
                            <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>