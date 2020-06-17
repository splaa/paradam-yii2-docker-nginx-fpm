<?php
// paradam.me.loc/PasswordChangeForm.php

namespace app\modules\user\forms;

use app\modules\admin\models\User;
use app\modules\user\Module;
use yii\base\Model;

/**
 * Password reset form
 */
class DescriptionChangeForm extends Model
{
	public $newDescription;

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
			[['newDescription'], 'required'],
		];
	}

	public function attributeLabels()
	{
		return [
			'newDescription' => Module::t('app', 'Описание'),
		];
	}

	/**
	 * @return boolean
	 * @throws \yii\base\Exception
	 */
	public function changeDescription ()
	{
		if ($this->validate()) {
			$user = $this->_user;
			$user->setDescription($this->newDescription);
			return $user->save();
		} else {
			return false;
		}
	}
}