<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $alternatives app\models\Alternative[] */
/* @var $criterias app\models\Criteria[] */
/* @var $evaluations array */

$this->title = 'Matrix';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matrix-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Isi Nilai Alternatif', [
            'class' => 'btn btn-outline-success btn-sm m-2',
            'data-toggle' => 'modal',
            'data-target' => '#inlineForm',
        ]) ?>
    </p>

    <table class="table table-striped mb-0">
        <caption>Matrik Keputusan(X)</caption>
        <tr>
            <th rowspan='2'>Alternatif</th>
            <th colspan='<?= count($criterias) ?>'>Kriteria</th>
        </tr>
        <tr>
            <?php foreach ($criterias as $criteria): ?>
                <th><?= Html::encode($criteria->criteria) ?></th>
            <?php endforeach; ?>
        </tr>
        <?php
        $X = [];
        foreach ($evaluations as $evaluation) {
            $X[$evaluation['id_alternative']][$evaluation['id_criteria']] = $evaluation['value'];
        }
        foreach ($alternatives as $alternative):
        ?>
            <tr>
                <th><?= Html::encode($alternative->name) ?></th>
                <?php foreach ($criterias as $criteria): ?>
                    <td><?= Html::encode($X[$alternative->id_alternative][$criteria->id_criteria] ?? '-') ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Isi Nilai Alternatif Modal -->
    <div class="modal fade" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="inlineFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inlineFormLabel">Isi Nilai Alternatif</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php $form = ActiveForm::begin(['action' => Url::to(['matrix/save'])]); ?>
                <div class="modal-body">
                    <?= $form->field(new \app\models\Evaluation(), 'id_alternative')->dropDownList(
                        \yii\helpers\ArrayHelper::map($alternatives, 'id_alternative', 'name'),
                        ['prompt' => 'Select Alternative']
                    ) ?>
                    <?= $form->field(new \app\models\Evaluation(), 'id_criteria')->dropDownList(
                        \yii\helpers\ArrayHelper::map($criterias, 'id_criteria', 'criteria'),
                        ['prompt' => 'Select Criteria']
                    ) ?>
                    <?= $form->field(new \app\models\Evaluation(), 'value')->textInput(['placeholder' => 'Value...']) ?>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>