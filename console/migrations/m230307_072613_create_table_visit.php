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
        $this->execute("
            create table if not exists ".Visit::tableName()."
            (
                id int auto_increment primary key,
                user_id  int           not null,
                sum      int           not null,
                discount int default 0 not null,
                constraint visitor_user_id_fk
                    foreign key (user_id) references ".User::tableName()." (id)
            );
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Visit::tableName());
    }

}
