<?php
// paradam.me.loc/User.php
	
	namespace app\modules\admin\models;
	
	
	use app\modules\user\models\User as ModuleUser;
    use Yii;
    use yii\helpers\ArrayHelper;

    class User extends ModuleUser
    {
        public const SCENARIO_ADMIN_CREATE = 'adminCreate';
        public const SCENARIO_ADMIN_UPDATE = 'adminUpdate';

        public $newPassword;
        public $newPasswordRepeat;

        public function rules()
        {
            return ArrayHelper::merge(parent::rules(), [
				[['newPassword', 'newPasswordRepeat'], 'required', 'on' => self::SCENARIO_ADMIN_CREATE],
				['newPassword', 'string', 'min' => 6],
				['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
			]);
		}
		
		public function scenarios()
		{
			
			$scenarios = parent::scenarios();
			$scenarios[self::SCENARIO_ADMIN_CREATE] = ['username', 'email', 'balance', 'status', 'newPassword', 'newPasswordRepeat'];
			$scenarios[self::SCENARIO_ADMIN_UPDATE] = ['username', 'email', 'balance', 'status', 'newPassword', 'newPasswordRepeat'];
			return $scenarios;
		}
		
		public function attributeLabels()
		{
			return ArrayHelper::merge(parent::attributeLabels(), [
				'newPassword' => Yii::t('app', 'USER_NEW_PASSWORD'),
				'newPasswordRepeat' => Yii::t('app', 'USER_REPEAT_PASSWORD'),
			]);
		}
		
		public function beforeSave($insert)
		{
			if (parent::beforeSave($insert)) {
				if (!empty($this->newPassword)) {
					$this->setPassword($this->newPassword);
				}
				return true;
			}
			return false;
		}
	}