<?php

namespace app\models;

use yii\db\ActiveRecord;

class Evaluation extends ActiveRecord
{
    public static function tableName()
    {
        return 'saw_evaluations'; // Nama tabel di database
    }
}