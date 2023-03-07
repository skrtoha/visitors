<?php

use common\models\User;
use frontend\models\PasswordResetRequestForm;
use yii\db\Migration;

/**
 * Class m230305_171222_init_rbac
 */
class m230305_171222_init_rbac extends Migration
{
    /**
     * @throws Exception
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $roleAdmin = $auth->createRole('admin');
        $auth->add($roleAdmin);

        $roleManager = $auth->createRole('manager');
        $auth->add($roleManager);

        $roleUser = $auth->createRole('user');
        $auth->add($roleUser);

        $user = new User();
        $user->username = 'admin';
        $user->email = Yii::$app->params['adminEmail'];
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword('');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if ($user->save()){
            $form = new PasswordResetRequestForm();
            $form->email = $user->email;
            if (!$form->sendEmail($user)){
                die('Ошибка отправки сообщения пользователю');
            }
            $auth->revokeAll($user->id);
            $auth->assign($roleAdmin, $user->id);
        }
        else die('Ошибка создания администратора');
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $this->truncateTable(User::tableName());
    }
}
