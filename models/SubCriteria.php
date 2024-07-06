<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class SubCriteria extends ActiveRecord
{
    public static function tableName()
    {
        return 'saw_sub_criterias';
    }

    public function rules()
    {
        return [
            [['id_criteria', 'name'], 'required'],
            [['id_criteria', 'weight_hr', 'target_pmo', 'weight_pmo', 'weight_pd'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['target_pmo'], 'default', 'value' => 0],
            [['target_pmo'], 'required', 'when' => function($model) {
                return Yii::$app->user->identity->role == 'Manager PMO';
            }, 'whenClient' => "function (attribute, value) {
                return $('#role').val() == 'Manager PMO';
            }"],
            [['weight_pmo'], 'required', 'when' => function($model) {
                return Yii::$app->user->identity->role == 'Manager PMO';
            }, 'whenClient' => "function (attribute, value) {
                return $('#role').val() == 'Manager PMO';
            }"],
            [['weight_pd'], 'required', 'when' => function($model) {
                return Yii::$app->user->identity->role == 'Project Director';
            }, 'whenClient' => "function (attribute, value) {
                return $('#role').val() == 'Project Director';
            }"],
        ];
    }

    public function getCriteria()
    {
        return $this->hasOne(Criteria::class, ['id_criteria' => 'id_criteria']);
    }
}
