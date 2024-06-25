<?php

use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $alternatives app\models\Alternative[] */
/* @var $model app\models\Alternative */

$this->title = 'Alternatif - Nama Karyawan';
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
                    <h4 class="card-title">Tabel Karyawan - Alternatif</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p class="card-text">
                            Data-data mengenai kandidat yang akan dievaluasi di representasikan dalam tabel berikut:
                        </p>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm m-2" data-toggle="modal" data-target="#inlineForm">
                        Tambah Karyawan
                    </button>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <caption>
                                Tabel Alternatif A<sub>i</sub>
                            </caption>
                            <tr>
                                <th>No</th>
                                <th colspan="2">Nama</th>
                            </tr>
                            <?php foreach ($alternatives as $index => $alternative): ?>
                            <tr>
                                <td class='right'><?= $index + 1 ?></td>
                                <td class='center'><?= Html::encode($alternative->name) ?></td>
                                <td>
                                    <div class='btn-group mb-1'>
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <?= Html::a('Edit', ['update', 'id' => $alternative->id_alternative], ['class' => 'dropdown-item']) ?>
                                            <?= Html::beginForm(['delete', 'id' => $alternative->id_alternative], 'post', [
                                                'data-confirm' => 'Apakah Anda yakin ingin menghapus item ini?',
                                                'class' => 'dropdown-item',
                                            ]) ?>
                                            <?= Html::submitButton('Hapus', [
                                                'class' => 'btn btn-link text-danger',
                                                'style' => 'padding: 0; border: none; background: none; color: red;'
                                            ]) ?>
                                            <?= Html::endForm() ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
Modal::begin([
    'title' => '<h4>Tambah Alternatif</h4>',
    'id' => 'inlineForm',
    'size' => 'modal-lg',
]);

$form = ActiveForm::begin([
    'action' => ['create'],
    'method' => 'post',
]);

echo '<div class="modal-body">';
echo $form->field($model, 'name')->textInput(['placeholder' => 'Nama Kandidat...'])->label('Name:');
echo '</div>';
echo '<div class="modal-footer">';
echo Html::button('Close', ['class' => 'btn btn-light-secondary', 'data-dismiss' => 'modal']);
echo Html::submitButton('Simpan', ['class' => 'btn btn-primary ml-1']);
echo '</div>';

ActiveForm::end();
Modal::end();
?>