<?php

namespace app\models;

use yii\db\ActiveRecord;

class Preference extends ActiveRecord
{
    public static function tableName()
    {
        return 'preference'; // Sesuaikan dengan nama tabel di database
    }

    public function rules()
    {
        return [
            [['id_alternative', 'id_criteria', 'value'], 'required'],
            [['id_alternative', 'id_criteria'], 'integer'],
            [['value'], 'number'],
        ];
    }
}
