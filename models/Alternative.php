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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }
}