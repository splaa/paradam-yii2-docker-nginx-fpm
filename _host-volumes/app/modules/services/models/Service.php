<?php

	namespace app\modules\services\models;

	use app\components\Currency;
	use app\modules\admin\models\User;
	use app\modules\user\models\query\UserQuery;
	use Yii;
	use yii\behaviors\TimestampBehavior;
	use yii\db\ActiveRecord;
	use yii\db\Expression;
	use yii\web\UploadedFile;

	/**
	 * This is the model class for table "service".
	 *
	 * @property int $id
	 * @property int|null $user_id
	 * @property string|null $name
	 * @property string|null $description
	 * @property float|null $price
	 * @property int|null $periodOfExecution
	 * @property string|null $link_foto_video_file
	 * @property int $created_at
	 * @property int $updated_at
	 * @property string $formatPrice
	 * @property string $convertPriceToUSD
	 *
	 * @property User $user
	 * @property ServiceQuestion[] $serviceQuestions
	 * @property Question[] $questions
	 */
	class Service extends \yii\db\ActiveRecord
	{
		/**
		 * @var UploadedFile
		 */
		public $imageFile;


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
					'value' => new Expression('NOW()'),
				]

			];
		}

		/**
		 * {@inheritdoc}
		 */
		public static function tableName()
		{
			return 'service';
		}

		/**
		 * {@inheritdoc}
		 */
		public function rules()
		{
			return [
				[['price', 'name', 'description'], 'required'],
				[['imageFile'], 'file', 'extensions' => 'png, jpg, mp4'],
				[['user_id', 'periodOfExecution'], 'integer'],
				[['description'], 'string'],
				[['price'], 'number'],
				[['price'], 'errorIfPriceLessSmsCost'],
				[['name'], 'string', 'max' => 256],
				[['link_foto_video_file'], 'string', 'max' => 255],
				[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
			];
		}


		/**
		 * @param $attribute
		 * @param $params
		 */
		public function errorIfPriceLessSmsCost($attribute, $params)
		{
			$user = User::findIdentity(Yii::$app->user->id);

			if (($this->$attribute % 5) != 0) {
				$this->addError($attribute, 'Число должно быть кратно 5.');
			}

			if ($user->convertSmsCostToUSD > $this->$attribute) {
				$this->addError($attribute, 'Цена должна быть выше за ' . $user->convertSmsCostToUSD);
			}

		}

		/**
		 * {@inheritdoc}
		 */
		public function attributeLabels()
		{
			return [
				'id' => Yii::t('app', 'ID'),
				'user_id' => Yii::t('app', 'User ID'),
				'name' => Yii::t('app', 'Name'),
				'description' => Yii::t('app', 'Description'),
				'price' => Yii::t('app', 'Price'),
				'periodOfExecution' => Yii::t('app', 'Period Of Execution'),
				'link_foto_video_file' => Yii::t('app', 'Link Foto Video File'),
				'created_at' => Yii::t('app', 'Created At'),
				'updated_at' => Yii::t('app', 'Updated At'),
			];
		}

		/**
		 * Gets query for [[User]].
		 *
		 * @return \yii\db\ActiveQuery|UserQuery
		 */
		public function getUser()
		{
			return $this->hasOne(User::className(), ['id' => 'user_id']);
		}

		/**
		 * Gets query for [[ServiceQuestions]].
		 *
		 * @return \yii\db\ActiveQuery|ServiceQuestionQuery
		 */
		public function getServiceQuestions()
		{
			return $this->hasMany(ServiceQuestion::className(), ['service_id' => 'id'])->inverseOf('service');
		}

		/**
		 * Gets query for [[Questions]].
		 *
		 * @return \yii\db\ActiveQuery|QuestionQuery
		 * @throws \yii\base\InvalidConfigException
		 */
		public function getQuestions()
		{
			return $this->hasMany(Question::className(), ['id' => 'question_id'])->viaTable('service_question', ['service_id' => 'id']);
		}

		/**
		 * {@inheritdoc}
		 * @return ServiceQuery the active query used by this AR class.
		 */
		public static function find()
		{
			return new ServiceQuery(get_called_class());
		}

		public function upload()
		{
			if ($this->validate()) {
				$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
				return true;
			} else {
				return false;
			}
		}

		public function saveImage($file)
		{

			$this->link_foto_video_file = $file;
			return $this->save(false);

		}

		public function deleteImage()
		{
			$imageUpLoadeModel = new ImageUpload();
			$imageUpLoadeModel->deleteCurrentImage($this->link_foto_video_file);
		}

		public function beforeDelete()
		{
			$this->deleteImage();
			return parent::beforeDelete();
		}

		public function getImage()
		{
			$image = new ImageUpload();
			if ($this->link_foto_video_file) {
				return '/' . $image->getFolder() . $this->link_foto_video_file;
			}

			return '/' . $image->getFolder() . 'no-image.png';
		}

		/**
		 * @return string
		 */
		public function getConvertPriceToUSD()
		{
			$number = Currency::convert($this->price, Currency::BITS_CURRENCY, Currency::USD_CURRENCY);
			return Currency::format($number, Currency::USD_CURRENCY, 1);
		}

		/**
		 * @return string
		 */
		public function getFormatPrice()
		{
			return Currency::format($this->price, Currency::BITS_CURRENCY);
		}
	}
