<?php
	
	namespace app\modules\user\forms;
	
	use app\modules\admin\models\User;
    use himiklab\yii2\recaptcha\ReCaptchaValidator2;
    use Yii;
    use yii\base\Model;

    /**
     * LoginForm is the model behind the login form.
     *
     * @property User|null $user This property is read-only.
     *
     */
    class PhoneLoginForm extends Model
    {
        public $phone;
		public $password;
		public $rememberMe = true;
		public $reCaptcha;
		
		private $_user = false;

		public const LOGIN_COUNT_LIMIT = 5;
		
		
		/**
		 * @return array the validation rules.
		 */
		public function rules()
		{
			return [
				// email and password are both required
				[['phone', 'password'], 'required'],
				// rememberMe must be a boolean value
				['rememberMe', 'boolean'],
				// password is validated by validatePassword()
				['password', 'validatePassword'],

				[['reCaptcha'], ReCaptchaValidator2::className(), 'uncheckedMessage' => 'Please confirm that you are not a bot.', 'when' => function($model){
					return Yii::$app->session->get('loginCount') >= self::LOGIN_COUNT_LIMIT;
				}]
			];
		}
		
		/**
		 * Validates the password.
		 * This method serves as the inline validation for password.
		 *
		 * @param string $attribute the attribute currently being validated
		 * @param array $params the additional name-value pairs given in the rule
		 */
		public function validatePassword($attribute, $params)
		{
			if (!$this->hasErrors()) {
				$user = $this->getUser();
				
				if (!$user || !$user->validatePassword($this->password)) {
					$this->addError('password', Yii::t('app', 'ERROR_WRONG_USERNAME_OR_PASSWORD'));
				} elseif ($user && $user->status == User::STATUS_BLOCKED) {
					$this->addError('username', Yii::t('app', 'ERROR_PROFILE_BLOCKED'));
				} elseif ($user && $user->status == User::STATUS_WAIT) {
					$this->addError('username', Yii::t('app', 'ERROR_PROFILE_NOT_CONFIRMED'));
				}
			}
		}
		
		/**
		 * Logs in a user using the provided username and password.
		 * @return bool whether the user is logged in successfully
		 */
		public function login()
		{
			if ($this->validate()) {
				return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
			}
			return false;
		}
		
		/**
		 * Finds user by [[username]]
		 *
		 * @return User|null
		 */
		public function getUser()
		{
			if ($this->_user === false) {
				$this->_user = User::findByPhone($this->phone) ?? User::findByUsername($this->phone);
			}
			
			return $this->_user;
		}
		
		public function attributeLabels()
		{
			return [
				'phone' => Yii::t('app', 'Ваш Телефон:'),
				'password' => Yii::t('app', 'Ваш Пароль:'),
				'rememberMe' => Yii::t('app', 'ЗАПОМНИТЕ МЕНЯ'),
			];
		}
	}
