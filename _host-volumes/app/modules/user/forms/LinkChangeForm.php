<?php
// paradam.me.loc/PasswordChangeForm.php

namespace app\modules\user\forms;

use app\modules\admin\models\User;
use app\modules\user\Module;
use yii\base\Model;

/**
 * Password reset form
 */
class LinkChangeForm extends Model
{
	public $newLink;

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
			[['newLink'], 'required'],
		];
	}

	public function attributeLabels()
	{
		return [
			'newLink' => Module::t('app', 'Сайт'),
		];
	}

	/**
	 * @return boolean
	 * @throws \yii\base\Exception
	 */
	public function changeLink ()
	{
		if ($this->validate()) {
			$user = $this->_user;
			$user->setLink($this->newLink);
			return $user->save();
		} else {
			return false;
		}
	}
}