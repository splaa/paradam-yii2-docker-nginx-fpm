<?php
// paradam.me.loc/SignupForm.php
	
	namespace app\modules\user\forms;
	
	use app\modules\user\models\User;
    use Yii;
    use yii\base\Model;

    /**
     * Signup form
     */
    class SignupForm extends Model
    {
        public $username;
        public $email;
        public $telephone;
        public $password;
        public $verifyCode;
		
		public function rules()
		{
			return [
				['username', 'filter', 'filter' => 'trim'],
				['username', 'required'],
				['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
				[['username'], 'unique',
					'targetAttribute' => 'username',
					'targetClass' => User::className(),
					'message' => 'Это имя пользователя уже занято.',
				],
				['username', 'string', 'min' => 2, 'max' => 255],
				
				['email', 'filter', 'filter' => 'trim'],
				['email', 'required'],
				['email', 'email'],
				['email', 'unique', 'targetClass' => User::className(), 'message' => 'This email address has already been taken.'],

//				['telephone', 'filter', 'filter' => 'trim'],
//				['telephone', 'required'],
//				['telephone', 'match', 'pattern' => '/^\+380\d{3}\d{2}\d{2}\d{2}$/'],
//				['telephone', 'unique', 'targetClass' => self::className(), 'message' => 'This telephone address has already been taken.'],

				['password', 'required'],
				['password', 'string', 'min' => 6],
				
				['verifyCode', 'captcha', 'captchaAction' => '/user/default/captcha'],
			];
		}
		
		/**
		 * Signs user up.
		 *
		 * @return User|null the saved model or null if saving fails
		 * @throws \yii\base\Exception
		 */
		public function signup()
		{
			if ($this->validate()) {
				$user = new User();
				$user->username = $this->username;
				$user->email = $this->email;
				$user->telephone = $this->telephone;
				$user->setPassword($this->password);
				$user->status = User::STATUS_WAIT;
				$user->generateAuthKey();
				$user->generateEmailConfirmToken();
				if ($user->save()) {
					Yii::$app->mailer->compose(['html' => '@app/modules/user/mails/emailConfirm'], ['user' => $user])
						->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
						->setTo($this->email)
						->setSubject('Email confirmation for ' . Yii::$app->name)
						->send();
					return $user;
				}
			}
			
			return null;
		}
	}