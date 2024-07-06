<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\SubCriteria */
/* @var $form yii\widgets\ActiveForm */
/* @var $criteriaList array */
/* @var $subCriteriaList array */

$this->title = 'Create Sub Criteria';
$this->params['breadcrumbs'][] = ['label' => 'Sub Criteria', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sub-criteria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_criteria')->dropDownList($criteriaList, [
        'prompt' => 'Select Criteria',
        'onchange' => '
            $.get("' . Url::to(['sub-criteria/get-sub-criteria']) . '?id_criteria=" + $(this).val(), function(data) {
                var options = "<option value=\'\'>Select Sub-Criteria</option>";
                $.each(data, function(index, value) {
                    options += "<option value=\'" + index + "\'>" + value + "</option>";
                });
                $("#subcriteria-name").html(options);
                if (Object.keys(data).length > 0) {
                    $("#subcriteria-dropdown").show();
                } else {
                    $("#subcriteria-dropdown").hide();
                }
            });
        '
    ]) ?>

    <?php if (Yii::$app->user->identity->role == 'HR Manager'): ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'weight_hr')->textInput() ?>
    <?php elseif (Yii::$app->user->identity->role == 'Manager PMO' || Yii::$app->user->identity->role == 'Project Director'): ?>
        <div id="subcriteria-dropdown" style="display: none;">
            <?= $form->field($model, 'name')->dropDownList($subCriteriaList, [
                'prompt' => 'Select Sub-Criteria',
                'id' => 'subcriteria-name',
                'onchange' => '
                    $.get("' . Url::to(['sub-criteria/get-sub-criteria-name']) . '?id=" + $(this).val(), function(data) {
                        $("#subcriteria-id").val(data.id);
                    });
                '
            ]) ?>
        </div>
        <?= $form->field($model, 'id')->hiddenInput(['id' => 'subcriteria-id'])->label(false) ?>
        <?php if (Yii::$app->user->identity->role == 'Manager PMO'): ?>
            <?= $form->field($model, 'weight_pmo')->textInput() ?>
        <?php elseif (Yii::$app->user->identity->role == 'Project Director'): ?>
            <?= $form->field($model, 'weight_pd')->textInput() ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$subCriteriaListJson = json_encode($subCriteriaList);
$script = <<< JS
$(document).ready(function() {
    var subCriteriaList = $subCriteriaListJson;
    if (Object.keys(subCriteriaList).length > 0) {
        $('#subcriteria-dropdown').show();
    } else {
        $('#subcriteria-dropdown').hide();
    }
});
JS;
$this->registerJs($script);
?>