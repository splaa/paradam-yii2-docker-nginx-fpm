<?php

// NOTE: Make sure this file is not accessible when deployed to production
// ПРИМЕЧАНИЕ. Убедитесь, что этот файл недоступен при развертывании в рабочей среде.
	if (!in_array(@$_SERVER['REMOTE_ADDR'], ['192.168.0.9', '127.0.0.1', '::1'])) {
		// У вас нет прав доступа к этому файлу.
		die('You are not allowed to access this file.');
	}
	
	defined('YII_DEBUG') or define('YII_DEBUG', true);
	defined('YII_ENV') or define('YII_ENV', 'test');
	
	require __DIR__ . '/../vendor/autoload.php';
	require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
	
	$config = require __DIR__ . '/../tests/_config/acceptance.php';
	
	(new yii\web\Application($config))->run();
