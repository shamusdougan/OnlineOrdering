<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\console\controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@app/console/migrations',
        ],
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
        'user-management' => 
        	[
        	'class' => 'webvimark\modules\UserManagement\UserManagementModule',
    		],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,  
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
			'transport' => 
				[
	            'class' => 'Swift_SmtpTransport',
	            'host' => 'smtp.office365.com',
	            'username' => 'crmadmin@irwinstockfeeds.com.au',
	            'password' => '1rwins001!',
	            'port' => '587',
	            'encryption' => 'tls',
	        	],
	        ],  
    ],
     
    'params' => $params,
];
