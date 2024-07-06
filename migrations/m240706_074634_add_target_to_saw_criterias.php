<?php

use yii\db\Migration;

/**
 * Class m240706_074634_add_target_to_saw_criterias
 */
class m240706_074634_add_target_to_saw_criterias extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('saw_criterias', 'target', $this->integer()->notNull());
    }

    public function safeDown()
    {
        $this->dropColumn('saw_criterias', 'target');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240706_074634_add_target_to_saw_criterias cannot be reverted.\n";

        return false;
    }
    */
}
