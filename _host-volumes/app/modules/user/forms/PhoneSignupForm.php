<?php
// paradam.me.loc/SignupForm.php
	
	namespace app\modules\user\forms;
	
	use app\modules\user\models\PhoneRecord;
    use app\modules\user\models\User;
	use borales\extensions\phoneInput\PhoneInputBehavior;
	use borales\extensions\phoneInput\PhoneInputValidator;
	use himiklab\yii2\recaptcha\ReCaptchaValidator2;
	use Yii;
    use yii\base\Model;
    use YoHang88\LetterAvatar\LetterAvatar;

    /**
     * Signup form
     */
    class PhoneSignupForm extends Model
    {
        public $username;
        public $email;
        public $telephone;
        public $password;
		public $first_name;
		public $last_name;
		public $birthday;
		public $country;
		public $verifyCodeTelephone;
		public $reCaptcha;
		public $subscribe;


		public function rules()
		{
			return [
				[['first_name', 'username', 'telephone', 'password', 'verifyCodeTelephone'], 'required'],

				['username', 'filter', 'filter' => 'trim'],
				['username', 'string', 'min' => 4, 'max' => 255],
				['username', 'match', 'pattern' => '/^[a-zA-Z0-9_\.]+$/', 'message' => 'В имени пользователя могут использоваться только символы латиницы и "." и "_"'],
				[['username'], 'unique',
					'targetAttribute' => 'username',
					'targetClass' => User::className(),
					'message' => 'Это имя пользователя уже занято.',
				],

//				['email', 'filter', 'filter' => 'trim'],
//				['email', 'email'],
//				['email', 'unique', 'targetClass' => User::className(), 'message' => 'Этот адрес электронной почты уже занят.'],

				['telephone', 'string'],
				[['telephone'], PhoneInputValidator::className()],
				['telephone', 'unique', 'targetClass' => PhoneRecord::class, 'message' => 'Этот телефон уже занят.'],

				['password', 'string', 'min' => 8],

				['first_name', 'string', 'min' => 1],

//				['birthday', 'string'],

				['verifyCodeTelephone', 'validateVerifyCode'],

//				['subscribe', 'compare', 'compareValue' => 1, 'message' => 'Выствите чебокс, иначе форма не отправится!'],

				['reCaptcha', ReCaptchaValidator2::className(), 'uncheckedMessage' => 'Пожалуйста, подтвердите, что вы не бот.', 'message' => 'Некорректный код'],
			];
		}

		/**
		 * @param $attribute
		 * @param $params
		 */
		public function validateVerifyCode($attribute, $params)
		{
			$codeAuth = Yii::$app->session->get('codeAuth');
			if ($this->$attribute != $codeAuth ) {
				$this->addError($attribute, 'Не верный код подтверждения.');
			}
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
				$user = new PhoneRecord();
				$user->username = $this->username;
				$user->email = $this->email;
				$user->telephone = $this->telephone;
				$user->first_name = $this->first_name;
				$user->last_name = $this->last_name;
				$user->subscribe = $this->subscribe;
				$user->birthday = date('Y-m-d',strtotime($this->birthday));
				$user->country = $this->country;
				$user->setPassword($this->password);
				$user->status = User::STATUS_ACTIVE;
				$user->generateAuthKey();
				$user->generateEmailConfirmToken();

				// Generate User Avatar
				$name = $this->username;
				if (!empty($this->last_name)) {
					$name = $this->first_name . ' ' . $this->last_name;
				}
				
				if ($user->save()) {
					$avatar = new LetterAvatar($name, 'square', User::SIZE_AVATAR_SMALL);
					$avatar->saveAs('images/user/avatar/' . $user->id . '-' . User::SIZE_AVATAR_SMALL . '.png');
					$avatar = new LetterAvatar($name, 'square',  User::SIZE_AVATAR_MEDIUM);
					$avatar->saveAs('images/user/avatar/' . $user->id . '-' . User::SIZE_AVATAR_MEDIUM . '.png');
					$avatar = new LetterAvatar($name, 'square', User::SIZE_AVATAR_BIG);
					$avatar->saveAs('images/user/avatar/' . $user->id . '-' . User::SIZE_AVATAR_BIG . '.png');

					if ($this->email) {
						Yii::$app->mailer->compose(['html' => '@app/modules/user/mails/phoneConfirm'], ['user' => $user])
							->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
							->setTo($this->email)
							->setSubject('Email confirmation for ' . Yii::$app->name)
							->send();
					}
					return $user;
				}
			}
			
			return null;
		}

		public function attributeLabels()
		{
			return [
				'subscribe' => Yii::t('app', 'USER_SUBSCRIBE'),
			];
		}
	}