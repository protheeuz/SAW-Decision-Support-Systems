<?php

use yii\db\Migration;

/**
 * Class m240706_093352_status_input_to_saw_sub_criterias
 */
class m240706_093352_status_input_to_saw_sub_criterias extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%saw_sub_criterias}}', 'status_input', $this->string()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%saw_sub_criterias}}', 'status_input');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240706_093352_status_input_to_saw_sub_criterias cannot be reverted.\n";

        return false;
    }
    */
}
