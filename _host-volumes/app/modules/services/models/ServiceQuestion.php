<?php

namespace app\modules\services\models;

use Yii;

/**
 * This is the model class for table "service_question".
 *
 * @property int $service_id
 * @property int $question_id
 *
 * @property Question $question
 * @property Service $service
 */
class ServiceQuestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'question_id'], 'required'],
            [['service_id', 'question_id'], 'integer'],
            [['service_id', 'question_id'], 'unique', 'targetAttribute' => ['service_id', 'question_id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => Yii::t('app', 'Service ID'),
            'question_id' => Yii::t('app', 'Question ID'),
        ];
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery|QuestionQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id'])->inverseOf('serviceQuestions');
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery|ServiceQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id'])->inverseOf('serviceQuestions');
    }

    /**
     * {@inheritdoc}
     * @return ServiceQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiceQuestionQuery(get_called_class());
    }
}
