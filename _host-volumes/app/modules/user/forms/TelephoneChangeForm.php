<?php
// paradam.me.loc/PasswordChangeForm.php

namespace app\modules\user\forms;

use app\modules\admin\models\User;
use app\modules\user\Module;
use Yii;
use yii\base\Model;

/**
 * Password reset form
 */
class TelephoneChangeForm extends Model
{
	public $currentPassword;
	public $telephone;
	public $verifyCodeTelephone;

	/**
	 * @var User
	 */
	private $_user;

	/**
	 * @param User $user
	 * @param array $config
	 */
	public function __construct(User $user, $config = [])
	{
		$this->_user = $user;
		parent::__construct($config);
	}

	public function rules()
	{
		return [
			[['currentPassword', 'telephone', 'verifyCodeTelephone'], 'required'],
			['currentPassword', 'currentPassword'],

			['telephone', 'filter', 'filter' => 'trim'],
			['telephone', 'match', 'pattern' => '/^\+380\d{3}\d{2}\d{2}\d{2}$/'],
			//['telephone', 'unique', 'targetClass' => PhoneRecord::class, 'message' => 'This telephone address has already been taken.'],

			['verifyCodeTelephone', 'validateVerifyCode'],
		];
	}


	public function attributeLabels()
	{
		return [
			'telephone' => Module::t('app', 'Ваш Телефон'),
			'verifyCodeTelephone' => Module::t('app', 'Проверочный код'),
			'currentPassword' => Module::t('app', 'Текущий пароль'),
		];
	}

	/**
	 * @param string $attribute
	 * @param array $params
	 */
	public function currentPassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			if (!$this->_user->validatePassword($this->$attribute)) {
				$this->addError($attribute, Module::t('app', 'ERROR_WRONG_CURRENT_PASSWORD'));
			}
		}
	}

	/**
	 * @param $attribute
	 * @param $params
	 */
	public function validateVerifyCode($attribute, $params)
	{
		$codeAuth = Yii::$app->session->get('codeAuth');
		if ($this->$attribute != $codeAuth) {
			$this->addError($attribute, 'Не верный код подтверждения.');
		}
	}

	/**
	 * @return boolean
	 * @throws \yii\base\Exception
	 */
	public function changeTelephone()
	{
		if ($this->validate()) {
			$user = $this->_user;
			$user->setTelephone($this->telephone);
			return $user->save();
		} else {
			return false;
		}
	}
}
