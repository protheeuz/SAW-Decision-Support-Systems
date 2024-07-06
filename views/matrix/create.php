<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Matrix */
/* @var $form yii\widgets\ActiveForm */
/* @var $alternatives array */
/* @var $criteria array */

$this->title = 'Create Matrix';
$this->params['breadcrumbs'][] = ['label' => 'Matrix', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="matrix-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_alternative')->dropDownList($alternatives, ['prompt' => 'Select Alternative']) ?>

    <?= $form->field($model, 'id_criteria')->dropDownList($criteria, ['prompt' => 'Select Criteria']) ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>