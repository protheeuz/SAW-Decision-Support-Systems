<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Criteria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="criteria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'criteria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'target')->textInput() ?>

    <?= $form->field($model, 'attribute')->dropDownList(['benefit' => 'Benefit', 'cost' => 'Cost']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>