<?php
	
	namespace app\modules\main;
	
	use Yii;

    /**
     * main module definition class
     */
    class Module extends \yii\base\Module
    {
        /**
         * {@inheritdoc}
         */
        public $controllerNamespace = 'app\modules\main\controllers';

        /**
		 * {@inheritdoc}
		 */
		public function init()
		{
			parent::init();
			$this->registerTranslations();
			// custom initialization code goes here
		}
		
		public function registerTranslations()
		{
			Yii::$app->i18n->translations['modules/main/*'] = [
				'class' => 'yii\i18n\PhpMessageSource',
				'basePath' => '@app/modules/main/messages',
				'fileMap' => [
					'modules/main/validation' => 'validation.php',
					'modules/main/form' => 'form.php',
				],
			];
		}
		
		public static function t($category, $message, $params = [], $language = null)
		{
			return Yii::t('modules/user/' . $category, $message, $params, $language);
		}
	}
