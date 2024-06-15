<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alternative */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Alternative';
$this->params['breadcrumbs'][] = ['label' => 'Alternatives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="alternative-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alternative-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>