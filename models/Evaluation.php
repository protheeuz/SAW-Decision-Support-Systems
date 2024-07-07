<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "saw_evaluations".
 *
 * @property int $id_alternative
 * @property int $id_criteria
 * @property float $value
 */
class Evaluation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'saw_evaluations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alternative', 'id_criteria', 'value'], 'required'],
            [['id_alternative', 'id_criteria'], 'integer'],
            [['value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_alternative' => 'Id Alternative',
            'id_criteria' => 'Id Criteria',
            'value' => 'Value',
        ];
    }
}