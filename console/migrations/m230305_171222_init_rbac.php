<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m230305_171222_init_rbac
 */
class m230305_171222_init_rbac extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $roleAdmin = $auth->createRole('admin');
        $auth->add($roleAdmin);

        $roleManager = $auth->createRole('manager');
        $auth->add($roleManager);

        $roleUser = $auth->createRole('user');
        $auth->add($roleUser);

        $user = User::findIdentity(1);
        if (is_null($user)) die('Необходимо сначала создать пользователя!');

        $auth->revokeAll(1);
        $auth->assign($roleAdmin, 1);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
