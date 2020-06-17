<?php
// paradam.me.loc/ProfileUpdateForm.php
	
	namespace app\modules\user\forms;
	
	use app\modules\admin\models\User;
    use app\modules\user\Module;
    use yii\base\Model;

    class ProfileUpdateForm extends Model
    {
        public $email;

        /**
         * @var User
         */
        private $_user;

        public function __construct(User $user, $config = [])
        {
			$this->_user = $user;
			$this->email = $user->email;
			parent::__construct($config);
		}
		
		public function rules()
		{
			return [
				['email', 'required'],
				['email', 'email'],
				[
					'email',
					'unique',
					'targetClass' => User::className(),
					'message' => Module::t('app', 'ERROR_EMAIL_EXISTS'),
					'filter' => ['<>', 'id', $this->_user->id],
				],
				['email', 'string', 'max' => 255],
			];
		}
		
		public function update()
		{
			if ($this->validate()) {
				$user = $this->_user;
				$user->email = $this->email;
				return $user->save();
			} else {
				return false;
			}
		}
	}