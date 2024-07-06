<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class SubCriteria extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'saw_sub_criterias';
    }

    public function rules()
    {
        return [
            [['id_criteria', 'name'], 'required'],
            [['id_criteria', 'weight_hr', 'weight_pmo', 'weight_pd'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['weight_hr', 'weight_pmo', 'weight_pd'], 'default', 'value' => 0],
        ];
    }

    public function getCriteria()
    {
        return $this->hasOne(Criteria::class, ['id_criteria' => 'id_criteria']);
    }
}