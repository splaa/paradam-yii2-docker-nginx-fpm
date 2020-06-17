<?php
// paradam.me.loc/PasswordChangeForm.php

namespace app\modules\user\forms;

use app\modules\admin\models\User;
use app\modules\user\Module;
use yii\base\Model;

/**
 * Password reset form
 */
class NameChangeForm extends Model
{
	public $newName;

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
			[['newName'], 'required'],
			['newName', 'string', 'min' => 1]
		];
	}

	public function attributeLabels()
	{
		return [
			'newName' => Module::t('app', 'Новое имя'),
		];
	}

	/**
	 * @return boolean
	 * @throws \yii\base\Exception
	 */
	public function changeName ()
	{
		if ($this->validate()) {
			$user = $this->_user;
			$user->setName($this->newName);
			return $user->save();
		} else {
			return false;
		}
	}
}