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
            [['criteria', 'weight', 'attribute'], 'required'],
            [['weight'], 'integer', 'min' => 1, 'max' => 20],
            [['criteria', 'attribute'], 'string', 'max' => 255],
        ];
    }
}