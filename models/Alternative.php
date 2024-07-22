<?php

namespace app\models;

use yii\db\ActiveRecord;

class Alternative extends ActiveRecord
{
    public static function tableName()
    {
        return 'saw_alternatives'; // Nama tabel di database
    }

    public function rules()
    {
        return [
            [['name', 'profession', 'age'], 'required'],
            [['name', 'profession'], 'string', 'max' => 255],
            [['age'], 'integer'],
        ];
    }
}