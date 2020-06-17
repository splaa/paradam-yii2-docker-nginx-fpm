<?php
	return [
		'components' => [
			'request' => [
				'cookieValidationKey' => 'jshd3qjaxp',
			],
			'assetManager' => [
				'linkAssets' => true,
			],
			'log' => [
				'traceLevel' => YII_DEBUG ? 3 : 0,
				'targets' => [
					[
						'class' => 'yii\log\FileTarget',
						'levels' => ['error'],
						'logFile' => '@app/runtime/logs/web-error.log'
					],
					[
						'class' => 'yii\log\FileTarget',
						'levels' => ['warning'],
						'logFile' => '@app/runtime/logs/web-warning.log'
					],
				],
			],
		],
	];