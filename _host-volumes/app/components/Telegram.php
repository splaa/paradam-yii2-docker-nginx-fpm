<?php


namespace app\components;

use danog\MadelineProto\API;
use Yii;
use yii\base\BaseObject;


class Telegram extends BaseObject
{
	public $telephone;
	public $message;
	public $username;

	public function __construct($telephone, $message, $username = 'User', $config = [])
	{
		parent::__construct($config);

		$this->telephone = '+' . trim($telephone);
		$this->message = $message;

		if ($username != 'User') {
			$this->username = $username;
		} else {
			$this->username = 'User ' . strtotime(date('YmdHis'));
		}
	}

	public function init()
	{
		parent::init(); // TODO: Change the autogenerated stub
	}

	public function message()
	{
		$request_data = [
			'data[add_phone_privacy_exception]' => true,
			'data[id]' => 'me',
			'data[first_name]' => $this->username,
			'data[last_name]' => '',
			'data[phone]' => $this->telephone
		];
		$curl = new CurlRequest();
		$curl->url = "http://telegram:9503/api/contacts.addContact?" . http_build_query($request_data);
		$curl->sendGet();

		$request_data = [
			'data[contacts][0][_]' => 'inputPhoneContact',
			'data[contacts][0][client_id]' => 0,
			'data[contacts][0][phone]' => $this->telephone,
			'data[contacts][0][first_name]' => $this->username,
			'data[contacts][0][last_name]' => ''
		];
		$curl = new CurlRequest();
		$curl->url = "http://telegram:9503/api/contacts.importContacts?" . http_build_query($request_data);
		$import =  $curl->sendGet();

		if (!empty($import['response']['imported'][0]['user_id'])) {
			$request_data = [
				'data[peer]' => $import['response']['imported'][0]['user_id'],
				'data[message]' => $this->message
			];
			$curl = new CurlRequest();
			$curl->url = "http://telegram:9503/api/messages.sendMessage?" . http_build_query($request_data);
			$message =  $curl->sendGet();

			if ($message) {
				return Yii::t('app', 'Сообщение отправленно!'); // TODO-splaandrey: создать категорию для переводом
			} else {
				return Yii::t('app', 'Ошибка при отправке сообщения!'); // TODO-splaandrey: создать категорию для переводом
			}
		} else {
			return Yii::t('app', 'Пользователь не найден!'); // TODO-splaandrey: создать категорию для переводом
		}
	}
}