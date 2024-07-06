<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Evaluation extends ActiveRecord
{
    public static function tableName()
    {
        return 'saw_evaluations';
    }

    public function rules()
    {
        return [
            [['id_alternative', 'id_criteria', 'value'], 'required'],
            [['id_alternative', 'id_criteria'], 'integer'],
            [['value'], 'number'],
        ];
    }

    public function getAlternative()
    {
        return $this->hasOne(Alternative::class, ['id_alternative' => 'id_alternative']);
    }

    public function getCriteria()
    {
        return $this->hasOne(Criteria::class, ['id_criteria' => 'id_criteria']);
    }
}