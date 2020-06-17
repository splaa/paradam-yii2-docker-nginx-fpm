<?php
// paradam.me.loc/PasswordChangeForm.php

namespace app\modules\user\forms;

use app\modules\admin\models\User;
use app\modules\user\Module;
use yii\base\Model;

/**
 * Password reset form
 */
class UserNameChangeForm extends Model
{
	public $newUserName;

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
			[['newUserName'], 'required'],

			['newUserName', 'filter', 'filter' => 'trim'],
			['newUserName', 'string', 'min' => 4, 'max' => 255],
			['newUserName', 'match', 'pattern' => '/^[a-zA-Z0-9_\.]+$/', 'message' => 'Username can be use only cyrillic symbols and "." and "_"'],
			//['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
			[['newUserName'], 'unique',
				'targetAttribute' => 'username',
				'targetClass' => \app\modules\user\models\User::className(),
				'message' => 'Это имя пользователя уже занято.',
			],
		];
	}

	public function attributeLabels()
	{
		return [
			'newUserName' => Module::t('app', 'Новый username'),
		];
	}

	/**
	 * @return boolean
	 * @throws \yii\base\Exception
	 */
	public function changeUserName ()
	{
		if ($this->validate()) {
			$user = $this->_user;
			$user->setUserName($this->newUserName);
			return $user->save();
		} else {
			return false;
		}
	}
}