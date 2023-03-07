<?php

namespace backend\controllers;

use yii\base\Controller;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
}