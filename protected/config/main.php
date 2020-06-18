<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'AdminLTE-2.4.2',
	'theme'=>'acetheme',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456*',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>false,
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db' => array(
            'connectionString' => 'mysql:host=172.18.0.155;dbname=jib',
            'emulatePrepare' => true,
            'username' => 'jib999',
            'password' => 'jibxtranet999*',
            'charset' => 'utf8',
        ),
        'msystem' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=172.18.0.155;dbname=msystem',
            'emulatePrepare' => true,
            'username' => 'jib999',
            'password' => 'jibxtranet999*',
            'charset' => 'utf8',
        ),
         'datablue' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=172.18.0.155;dbname=finance',
            'emulatePrepare' => true,
            'username' => 'jib999',
            'password' => 'jibxtranet999*',
            'charset' => 'utf8',
        ),
        'jibhr' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=172.18.0.155;dbname=jibhr',
            'emulatePrepare' => true,
            'username' => 'jib999',
            'password' => 'jibxtranet999*',
            'charset' => 'utf8',
        ),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);