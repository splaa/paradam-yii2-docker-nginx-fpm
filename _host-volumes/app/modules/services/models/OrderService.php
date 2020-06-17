<?php

namespace app\modules\services\models;

use app\modules\message\models\Message;
use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order_service".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $executor_id
 * @property int $service_id
 * @property string|null $answers
 * @property string|null $comment
 * @property int|null $status 1 - finish | 0 - started
 * @property int|null $amount
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $customer
 * @property User $executor
 * @property Service $service
 * @property Message $message
 */
class OrderService extends \yii\db\ActiveRecord
{
	const STATUSES = [
		0 => 'Ожидание',
		1 => 'Задание выполненно',
		2 => 'Исполнитель отказался от задания',
		3 => 'Задание выполненно и подтвержденно заказчиком',
		4 => 'Заказчик открыл диспут',
		'delete' => 'Заказ удален или перемещен в архив',
	];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_service';
    }

	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
				],
				'value' => new Expression('NOW()'),
			]
		];
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'executor_id', 'service_id'], 'required'],
            [['customer_id', 'executor_id', 'service_id', 'status', 'amount'], 'integer'],
            [['answers', 'comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'executor_id' => 'Executor ID',
            'service_id' => 'Service ID',
            'answers' => 'Answers',
            'comment' => 'Comment',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

	public static function getStatusByType($status = '')
	{
		return ArrayHelper::getValue(self::STATUSES, $status, self::STATUSES['delete']);
	}
}
