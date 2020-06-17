<?php


	namespace app\modules\services\models;


	use yii\base\Model;

	class AnswerTheQuestions extends Model
	{
		public string $answer = 'Ответьте пожалуста на вопрос.';

		public function rules()
		{
			return [
				[['answer'], 'required'],
			];
		}

	}