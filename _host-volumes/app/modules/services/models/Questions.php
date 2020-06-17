<?php


	namespace app\modules\services\models;


	use yii\base\Model;

	class Questions extends Model
	{
		/**
		 * @var array виртуальный атрибут для хранения вопросов
		 */
		public $questions = [];

		public function rules()
		{
			return [
				[['question'], 'self'],
			];
		}


	}