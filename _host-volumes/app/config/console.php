<?php
	
	
	$config = [
		'id' => 'basic-console',
		'controllerNamespace' => 'app\commands',
		'modules' => [
			'admin' => [
				'class' => 'app\modules\admin\Module',
				'controllerNamespace' => 'app\modules\admin\commands',
			],
			'main' => [
				'class' => 'app\modules\main\Module',
				'controllerNamespace' => 'app\modules\main\commands',
			],
			'user' => [
				'class' => 'app\modules\user\Module',
				'controllerNamespace' => 'app\modules\user\commands',
			],
		],
	];
	
	if (YII_ENV_DEV) {
		// configuration adjustments for 'dev' environment
		$config['bootstrap'][] = 'gii';
		$config['modules']['gii'] = [
			'class' => 'yii\gii\Module',
		];
	}
	
	return $config;
