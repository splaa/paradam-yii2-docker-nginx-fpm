<?php

namespace app\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "subscribe".
 *
 * @property int $id
 * @property int|null $subscriber_id
 * @property int|null $user_id
 * @property string|null $created_at
 *
 * @property User $subscriber
 * @property User $user
 */
class Subscribe extends \yii\db\ActiveRecord
{
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
    public static function tableName()
    {
        return 'subscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subscriber_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subscriber_id' => 'Subscriber ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Subscriber]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriber()
    {
        return $this->hasOne(User::className(), ['id' => 'subscriber_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public static function checkSubscribe($user_id, $subscriber_id) {
    	$select =  Subscribe::find()
		    ->select(['id'])
		    ->where(['user_id' => $user_id])
		    ->andWhere(['subscriber_id' => $subscriber_id])
		    ->one();

	    return [
	    	'subscribe_id' => $select->id ?? 0,
		    'count' => Subscribe::find()->where(['user_id' => $user_id])->count()
	    ];
    }
}
