<?php
	// paradam.me.loc/config/common.php
	
	use yii\helpers\ArrayHelper;
	
	$params = ArrayHelper::merge(
		require(__DIR__ . '/params.php'),
		require(__DIR__ . '/params-local.php')
	);
	
	return [
		'name' => 'Paradam.me',
		'basePath' => dirname(__DIR__),
		'language' => 'ru',
		'bootstrap' => [
			'log',
			'app\modules\admin\Bootstrap',
			'app\modules\main\Bootstrap',
			'app\modules\user\Bootstrap'
		],
		'modules' => [
			'admin' => [
				'class' => 'app\modules\admin\Module',
				'layout' => '/admin/main'
			],
			'main' => [
				'class' => 'app\modules\main\Module',
			],
			'user' => [
				'class' => 'app\modules\user\Module',
				'passwordResetTokenExpire' => 3600,
			],
			'services' => [
				'class' => 'app\modules\services\Module'
			],
			'message' => [
				'class' => 'app\modules\message\Module',
			],
			'search' => [
				'class' => 'app\modules\search\Module',
			],
			'robotsTxt' => [
				'class' => 'execut\robotsTxt\Module',
				'components'    => [
					'generator' => [
						'class' => \execut\robotsTxt\Generator::class,
						'userAgent' => [
							'*' => [
								'Disallow' => [
									"/"
								],
								'Allow' => [
								],
							],
						],
					],
				],
			],
		],
		'aliases' => [
			'@languages' => '@vendor/annexare/countries-list/dist',
			'@bower' => '@vendor/bower-asset',
			'@npm' => '@vendor/npm-asset',
			'@tests' => '@app/tests',
		],
		'components' => [
			'db' => [
				'class' => 'yii\db\Connection',
				'charset' => 'utf8',
			],
			'i18n' => [
				'translations' => [
					'app' => [
						'class' => 'yii\i18n\PhpMessageSource',
						'forceTranslation' => false,
					],
				],
			],
			'urlManager' => [
				'class' => 'codemix\localeurls\UrlManager',
				'enablePrettyUrl' => true,
				'showScriptName' => false,
				'languages' => ['ru'], // en
				'enableLanguagePersistence' => true,
				'on languageChanged' => 'app\modules\user\models\User::onLanguageChanged',
				'rules' => [
					['pattern' => 'robots', 'route' => 'robotsTxt/web/index', 'suffix' => '.txt'],
					'' => 'main/default/index',
					'site/about' => 'main/default/about',
					'contact' => 'main/contact/index',

					// Messages
					'message/create' => 'message/message/create',
					'message/settings' => 'message/message/settings',
					'message' => 'message/message/index',
					'message/<id>' => 'message/message/view',

					// Public user
					'public/subscribe' => 'user/public/subscribe',

					// search
					'search' => 'search/default/index',

					// API
					'api/search' => 'search/default/query',

					[
						'pattern' => '<username>',
						'route' => 'user/public',
						'normalizer' => false, // disable normalizer for this rule
					],

					// User Action
					'user/login' => 'user/default/login',
					'user/logout' => 'user/default/logout',
					'user/forgotten' => 'user/default/forgotten',

					'<_a:error>' => 'main/default/<_a>',

					'<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
					'<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
					'<_m:[\w\-]+>' => '<_m>/default/index',
					'<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
				],
			],
			'mailer' => [
				'class' => 'yii\swiftmailer\Mailer',
			],
			'cache' => [
				'class' => 'yii\caching\FileCache',
			],
			'log' => [
				'class' => 'yii\log\Dispatcher',
			],
			[
				'class' => 'app\components\grid\ActionColumn',
			],
		],
		'params' => $params,
	];