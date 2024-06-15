<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Criteria */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Criteria';
$this->params['breadcrumbs'][] = ['label' => 'Criteria', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="criteria-create">
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