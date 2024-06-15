<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Criteria */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update Criteria: ' . $model->criteria;
$this->params['breadcrumbs'][] = ['label' => 'Criteria', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->criteria, 'url' => ['view', 'id' => $model->id_criteria]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="criteria-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="criteria-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'criteria')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'attribute')->dropDownList(['benefit' => 'Benefit', 'cost' => 'Cost']) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>