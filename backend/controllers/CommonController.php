<?php

namespace backend\controllers;

use yii\base\Controller;
use yii\base\Exception;

class CommonController extends Controller
{
    /**
     * Проверяет пользователя на наличие прав
     * @throws Exception
     */
    public function checkRole($role){
        if (!\Yii::$app->user->can($role)){
            throw new Exception('Недостаточно прав');
        }
    }
}