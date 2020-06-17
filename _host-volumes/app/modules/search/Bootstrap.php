<?php

	namespace app\modules\search;
	
	use yii\base\BootstrapInterface;

    class Bootstrap implements BootstrapInterface
    {
        public function bootstrap($app)
        {
            $app->i18n->translations['modules/user/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'forceTranslation' => true,
                'basePath' => '@app/modules/search/messages',
                'fileMap' => [
                    'modules/user/module' => 'module.php',
                ],
			];
		}
	}