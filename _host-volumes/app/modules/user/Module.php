<?php
	
	namespace app\modules\user;
	
	use Yii;

    /**
     * user module definition class
     */
    class Module extends \yii\base\Module
    {
        /**
         * {@inheritdoc}
         */
        public $controllerNamespace = 'app\modules\user\controllers';
        /**
         * срок истечения регистрации.
		 * @var int
		 */
		public $emailConfirmTokenExpire = 259200; // 3 days
		/**
		 * @var int
		 */
		public $passwordResetTokenExpire = 3600;
		
		/**
		 * {@inheritdoc}
		 */
		public function init()
		{
			parent::init();
			
			// custom initialization code goes here
		}
		
		public static function t($category, $message, $params = [], $language = null)
		{
			return Yii::t('modules/user/' . $category, $message, $params, $language);
		}
	}
