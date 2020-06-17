<?php
// paradam.me.loc/common-local.php

return [
    'components' => [
        'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
            'siteKeyV2' => '6LdwqdMUAAAAAKOB9PxmuiMXlLdlb9PlQSQxq2LH',
            'secretV2' => '6LdwqdMUAAAAACSvAL73YWp2uyxHOT-A2HCxRs-r',
            'siteKeyV3' => '',
            'secretV3' => '',
        ],
        'db' => [
//				host=mysql // название контейгера в docker-compose.yml
            'dsn' => 'mysql:host=mysql;dbname=paradam',
            'username' => 'splaa',
            'password' => 'splaa1977',
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