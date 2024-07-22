<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alternative */

$this->title = 'Edit Alternative: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Alternatives', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_alternative]];
$this->params['breadcrumbs'][] = 'Edit';
?>

<div class="page-heading">
    <h3>Alternatif Edit</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Data</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <?php $form = ActiveForm::begin([
                                'action' => ['update', 'id' => $model->id_alternative],
                                'method' => 'post',
                            ]); ?>

                            <div class="form-group">
                                <?= $form->field($model, 'id_alternative')->hiddenInput()->label(false) ?>
                                <?= $form->field($model, 'name')->textInput(['value' => $model->name]) ?>
                                <?= $form->field($model, 'profession')->textInput(['value' => $model->profession]) ?>
                                <?= $form->field($model, 'age')->textInput(['type' => 'number', 'value' => $model->age]) ?>
                            </div>
                            <div class="form-group">
                                <?= Html::submitButton('Edit Data', ['class' => 'btn btn-info btn-sm']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>