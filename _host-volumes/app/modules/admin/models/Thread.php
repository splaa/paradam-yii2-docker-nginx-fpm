<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "thread".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $created_at
 * @property int|null $creator_id
 *
 * @property Message[] $messages
 * @property UserThread[] $userThreads
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['creator_id'], 'integer'],
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
            'created_at' => 'Created At',
            'creator_id' => 'Creator ID',
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['thread_id' => 'id']);
    }

    /**
     * Gets query for [[UserThreads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserThreads()
    {
        return $this->hasMany(UserThread::className(), ['thread_id' => 'id']);
    }
}
