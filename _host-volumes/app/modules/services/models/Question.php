<?php
	
	namespace app\modules\services\models;
	
	use Yii;
	use yii\behaviors\TimestampBehavior;
	use yii\db\ActiveRecord;
	use yii\db\Expression;

	/**
	 * This is the model class for table "question".
	 *
	 * @property int $id
	 * @property int|null $created_at
	 * @property int|null $updated_at
	 * @property string $question
	 * @property int|null $status
	 *
	 * @property ServiceQuestion[] $serviceQuestions
	 * @property Service[] $services
	 */
	class Question extends \yii\db\ActiveRecord
	{
		/**
		 * @var array виртуальный атрибут для хранения вопросов
		 */
		public $questions;
		/**
		 * @var @var bool $convention пользовательское соглашение checkbox
		 */
		public $convention;

		public function behaviors()
		{
			return [
				[
					'class' => TimestampBehavior::class,
					'attributes' => [
						ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
						ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
					],
					// можно установить datetime
					'value' =>new Expression('NOW()'),
				]
			
			];
		}
		
		/**
		 * {@inheritdoc}
		 */
		public static function tableName()
		{
			return 'question';
		}
		
		/**
		 * {@inheritdoc}
		 */
		public function rules()
		{
			return [
				['status', 'integer'],
				[['question'], 'required'],
				[['question'], 'string', 'max' => 255],
				['convention', 'compare', 'compareValue' => 1, 'message' => 'Выствите чебокс, иначе форма не отправится!'],

			];
		}
		
		/**
		 * {@inheritdoc}
		 */
		public function attributeLabels()
		{
			return [
				'id' => Yii::t('app', 'ID'),
				'created_at' => Yii::t('app', 'Created At'),
				'updated_at' => Yii::t('app', 'Updated At'),
				'question' => Yii::t('app', 'Question'),
				'convention' => Yii::t('app', 'Я принимаю пользовательское соглашение.'),
				'status' => Yii::t('app', 'Status'),
			];
		}
		
		/**
		 * Gets query for [[ServiceQuestions]].
		 *
		 * @return \yii\db\ActiveQuery|ServiceQuestionQuery
		 */
		public function getServiceQuestions()
		{
			return $this->hasMany(ServiceQuestion::className(), ['question_id' => 'id'])->inverseOf('question');
		}
		
		/**
		 * Gets query for [[Services]].
		 *
		 * @return \yii\db\ActiveQuery|ServiceQuery
		 * @throws \yii\base\InvalidConfigException
		 */
		public function getServices()
		{
			return $this->hasMany(Service::className(), ['id' => 'service_id'])->viaTable('service_question', ['question_id' => 'id']);
		}
		
		/**
		 * {@inheritdoc}
		 * @return QuestionQuery the active query used by this AR class.
		 */
		public static function find()
		{
			return new QuestionQuery(get_called_class());
		}
	}
