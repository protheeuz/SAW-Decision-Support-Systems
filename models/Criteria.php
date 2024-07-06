<?php

namespace app\models;

use yii\db\ActiveRecord;

class Criteria extends ActiveRecord
{
    public static function tableName()
    {
        return 'saw_criterias';
    }

    public function rules()
    {
        return [
            [['criteria', 'weight', 'attribute', 'target'], 'required'],
            [['weight', 'target'], 'integer', 'min' => 1],
            [['criteria', 'attribute'], 'string', 'max' => 255],
        ];
    }

    public function getSubCriterias()
    {
        return $this->hasMany(SubCriteria::class, ['id_criteria' => 'id_criteria']);
    }
}