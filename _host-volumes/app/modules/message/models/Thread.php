<?php

namespace app\modules\message\models;

use app\modules\user\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "thread".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 *
 * @property Message[] $messages
 * @property Message[] $message
 * @property Message[] $messageWriter
 * @property UserThread[] $userThreads
 * @property User $creator
 * @property int $creator_message_exists
 */
class Thread extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'thread';
    }

	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
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
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['thread_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['thread_id' => 'id'])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageWriter()
    {
        return $this->hasOne(Message::className(), ['thread_id' => 'id'])->where(['NOT', ['author_id' => \Yii::$app->user->id]]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserThreads()
    {
        return $this->hasMany(UserThread::className(), ['thread_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return int
     */
    public function getCreatorMessageExists()
    {
        return (int)Message::find()->where(['author_id' => $this->creator_id])->count();
    }
}
