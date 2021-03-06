<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
define('CONFIG_PATH', dirname(__FILE__));
define('THEMES_PATH', realpath(CONFIG_PATH . DIRECTORY_SEPARATOR . '..'
		. DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'themes'));

define('PROJECT_TYPE_DEDICATED', 'Dedicated');
define('PROJECT_TYPE_FIXED_BID', 'Fixed Bid');

define('_SAVE_END_CLOSE', ' & close');
define('_SAVE_END_EDIT', ' & edit');
define('_SAVE_END_NEW', ' & new');

return array(
	'basePath' => realpath(CONFIG_PATH . DIRECTORY_SEPARATOR . '..'),
	'name' => 'Human Resource Data Center',
	'timeZone' => 'Asia/Ho_Chi_Minh',
	'theme' => 'hr',
	// preloading 'log' component
	'preload' => array('log'),
	'defaultController' => 'dashboard',
	// autoloading model and component classes
	'import' => array(
		'application.controllers.*',
		'application.models.*',
		'application.components.*',
		'ext.giix-components.*', // giix components
	),
	'modules' => array(
		// uncomment the following to enable the Gii tool
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => '123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters' => array('127.0.0.1', '::1'),
			'generatorPaths' => array(
				'ext.giix-core', // giix generators
			),
		),
	),
	// application components
	'components' => array(
		'user' => array(
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			'class' => 'WebUser'
		),
		// uncomment the following to enable URLs in path-format
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				'resourceallocation/<id:\d+>' => 'projects/view',
				'resourceallocation/<action:\w+>/<id:\d+>' => 'projects/<action>',
				'resourceallocation/<action:\w+>' => 'projects/<action>',

				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),
		/*'db' => array(
			'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=hrdc',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'errorHandler' => array(
			// use 'site/error' action to display errors
			'errorAction' => 'site/error',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error',
				),
				// uncomment the following to show log messages on web pages
				array(
					'class' => 'CWebLogRoute',
				),

			),
		),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
		'timeZone' => 'Asia/Ho_Chi_Minh',
		'dbTimeZone' => 'GMT',
		'projectTypes' => array(
			1 => PROJECT_TYPE_DEDICATED,
			2 => PROJECT_TYPE_FIXED_BID,
		),
		'roles' => array(
			1 => 'PM',
			2 => 'TechLead',
			3 => 'Dev',
			4 => 'Supporter',
			5 => 'QA'
		),
		'userRoles' => array(
			'Dev', 'Admin', 'BOM', 'Chief', 'PM'
		)
	),
);
