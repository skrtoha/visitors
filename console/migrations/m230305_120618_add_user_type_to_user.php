<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m230305_120618_add_user_type_to_user
 */
class m230305_120618_add_user_type_to_user extends Migration
{
    public function up()
    {
        $this->addColumn(
            User::tableName(),
            'type',
            $this->integer(1)
                ->defaultValue(User::TYPE_ADMINISTRATOR)
                ->comment('1 - administrator, 2 - manager, 3 - user')
        );
        $this->addColumn(
            User::tableName(),
            'phone',
            $this->string(20)->defaultValue(null)
        );
    }

    public function down()
    {
        $this->dropColumn(User::tableName(), 'type');
        $this->dropColumn(User::tableName(), 'phone');
    }

}
