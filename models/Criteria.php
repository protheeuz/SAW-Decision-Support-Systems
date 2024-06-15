<?php

namespace app\models;

use yii\db\ActiveRecord;

class Criteria extends ActiveRecord
{
    public static function tableName()
    {
        return 'saw_criterias'; // Nama tabel di database
    }

    public function rules()
    {
        return [
            [['criteria', 'weight', 'attribute'], 'required'],
            [['weight'], 'number'],
            [['criteria', 'attribute'], 'string', 'max' => 255],
        ];
    }
}