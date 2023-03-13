<?php

use common\models\User;
use common\models\Visit;
use yii\db\Migration;

/**
 * Class m230307_072613_create_table_visit
 */
class m230307_072613_create_table_visit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Visit::tableName(), [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'sum' => $this->integer()->notNull(),
            'discount' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'visitor_user_id_fk',
            Visit::tableName(),
            ['user_id'],
            User::tableName(),
            ['id']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Visit::tableName());
    }

}
