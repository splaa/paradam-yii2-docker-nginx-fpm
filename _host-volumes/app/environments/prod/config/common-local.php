<?php
	// paradam.me.loc/common-local.php
	
	return [
		'components' => [
			'db' => [
				'dsn' => 'mysql:host=localhost;dbname=example_db',
				'username' => 'root',
				'password' => 'root',
//				'tablePrefix' => 'keys_',
			],
			'mailer' => [
				'useFileTransport' => true,
			],
			'cache' => [
				'class' => 'yii\caching\FileCache',
			],
		],
	];