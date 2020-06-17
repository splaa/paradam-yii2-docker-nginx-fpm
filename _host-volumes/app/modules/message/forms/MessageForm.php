<?php


namespace app\modules\message\forms;


use app\modules\admin\models\User;
use yii\base\Model;

class MessageForm extends Model
{
	public $text;
	public $user_id;


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['text', 'safe'],
			['user_id', 'required'],
		];
	}

	public function attributeLabels()
	{
		return [
			'text' => 'Ваше сообщзение'
		];
	}
}