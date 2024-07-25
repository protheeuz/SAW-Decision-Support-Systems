<?php

use yii\db\Migration;

/**
 * Class m240725_051520_update_primary_key_saw_evaluations
 */
class m240725_051520_update_primary_key_saw_evaluations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Drop the existing primary key
        $this->dropPrimaryKey('PRIMARY', 'saw_evaluations');

        // Add new primary key with id_alternative, id_criteria, and year
        $this->addPrimaryKey('pk_saw_evaluations', 'saw_evaluations', ['id_alternative', 'id_criteria', 'year']);
    }

    public function safeDown()
    {
        // Drop the new primary key
        $this->dropPrimaryKey('pk_saw_evaluations', 'saw_evaluations');

        // Add the old primary key back
        $this->addPrimaryKey('PRIMARY', 'saw_evaluations', ['id_alternative', 'id_criteria']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240725_051520_update_primary_key_saw_evaluations cannot be reverted.\n";

        return false;
    }
    */
}
