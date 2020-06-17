<?php

namespace app\modules\user\forms;

use app\modules\admin\models\User;
use app\modules\user\Module;
use yii\base\Model;

/**
 * Password reset form
 */
class LanguageAddForm extends Model
{
	public $languages;

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
			[['languages'], 'required'],
		];
	}

	public function attributeLabels()
	{
		return [
			'languages' => Module::t('app', 'Языки'),
		];
	}

	/**
	 * @return boolean
	 * @throws \yii\base\Exception
	 */
	public function addLanguages ()
	{
		if ($this->validate()) {
			$user = $this->_user;
			$user->setLanguages(implode(',', $this->languages));
			return $user->save();
		} else {
			return false;
		}
	}
}