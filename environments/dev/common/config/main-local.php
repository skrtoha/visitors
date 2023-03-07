<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'sms' => [
            'class'    => 'ladamalina\smsc\Smsc',
            'login'     => '*******',
            'password'   => '*******',
            'post' => true,
            'https' => true,
            'charset' => 'utf-8',
            'debug' => false,
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtp',
                'host' => 'smtp.yandex.ru',
                'username' => '********',
                'password' => '**********',
                'port' => 25,
                'encryption' => 'ssl',
            ],
        ],
    ],
];
