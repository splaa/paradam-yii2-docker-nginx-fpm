<?php
	
	return [
		'adminEmail' => '',
		'supportEmail' => '',
		'supportName' => '',
		'senderEmail' => '',
		'senderName' => '',
		'user.passwordResetTokenExpire' => 3600,

		'api' => [
			'telegram_phone' => '+380980183456',
			'tg' => [
				'authorization' => [
					'default_temp_auth_key_expires_in' => 315576000, // я установил 10 лет, что бы не авторизовывать приложение повторно.
				],
				'app_info' => [ // Эти данные мы получили после регистрации приложения на https://my.telegram.org
					'api_id' => '257313',
					'api_hash' => 'ff458dd210d0e2d278d802b87da8d3cb',
				],
				'logger' => [ // Вывод сообщений и ошибок
					'logger' => 2, // выводим сообещения через echo
				],
				'max_tries' => [ // Количество попыток установить соединения на различных этапах работы. Лучше не уменьшать, так как телеграм не всегда отвечает с первого раза
					'query' => 5,
					'authorization' => 5,
					'response' => 5,
				],
				'updates' => [ // Я обновляю данные прямыми запросами, поэтому обновления с каналов и чатов мне не требуются.
					'handle_updates' => false,
					'handle_old_updates' => false,
				]
			],
			'smsc' => [
				'login' => 'yprabota@gmail.com', // логин клиента
				'password' => '47Pdm,47', // пароль
				'post' => '', // использовать метод POST
				'https' => '', // использовать HTTPS протокол
				'charset' => 'utf-8', // кодировка сообщения: utf-8, koi8-r или windows-1251 (по умолчанию)
				'debug' => 0, // флаг отладки
				'from' => 'api@smsc.ua' // e-mail адрес отправителя
			]
		]
	];
