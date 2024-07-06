<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubCriteria */
/* @var $form yii\widgets\ActiveForm */
/* @var $criteriaList array */
/* @var $existingSubCriteriaList array */

?>

<div class="sub-criteria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_criteria')->dropDownList($criteriaList, ['prompt' => 'Pilih Kriteria']) ?>

    <?php if (Yii::$app->user->identity->role == 'HR Manager') : ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'weight_hr')->textInput() ?>
    <?php elseif (Yii::$app->user->identity->role == 'Manager PMO' || Yii::$app->user->identity->role == 'Project Director') : ?>
        <?= $form->field($model, 'id')->dropDownList($existingSubCriteriaList, ['prompt' => 'Pilih Sub Kriteria']) ?>
        <?php if (Yii::$app->user->identity->role == 'Manager PMO') : ?>
            <?= $form->field($model, 'weight_pmo')->textInput() ?>
        <?php elseif (Yii::$app->user->identity->role == 'Project Director') : ?>
            <?= $form->field($model, 'weight_pd')->textInput() ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>