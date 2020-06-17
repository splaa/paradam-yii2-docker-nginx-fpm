<?php

namespace app\modules\user\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $type 0 => profile, 1 => add_funds, 2 => service, 3 => photo, 4 => video, 5 => products, 6 => investment, 7 => message
 * @property string|null $additional
 * @property string|null $created_at
 *
 * @property User $user
 */
class Activity extends \yii\db\ActiveRecord
{
	public const ACTIVITY_TYPE_PROFILE = 0;
	public const ACTIVITY_TYPE_ADD_FUNDS = 1;
	public const ACTIVITY_TYPE_SERVICE = 2;
	public const ACTIVITY_TYPE_PHOTO = 3;
	public const ACTIVITY_TYPE_VIDEO = 4;
	public const ACTIVITY_TYPE_PRODUCTS = 5;
	public const ACTIVITY_TYPE_INVESTMENT = 6;
	public const ACTIVITY_TYPE_MESSAGE = 7;
	public const ACTIVITY_TYPE_TRANSFER = 8;
	public const ACTIVITY_TYPE_REMOVE_THREAD = 9;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
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
            [['user_id', 'type'], 'integer'],
            [['additional'], 'string'],
            [['created_at'], 'safe'],
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
            'user_id' => 'User ID',
            'type' => 'Type',
            'additional' => 'Additional',
            'created_at' => 'Created At',
        ];
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

    public function getNameType($type) {
    	switch ($type) {
		    case 0:
		    	return 'Profile';
		    	break;
		    case 1:
			    return 'Add funds';
		    	break;
		    case 2:
			    return 'Service';
		    	break;
		    case 3:
			    return 'Photo';
		    	break;
		    case 4:
			    return 'Video';
		    	break;
		    case 5:
			    return 'Products';
		    	break;
		    case 6:
		    	return 'Investment';
		    	break;
		    case 7:
		    	return 'Message';
		    	break;
		    case 8:
		    	return 'Transfer';
		    	break;
		    case 9:
		    	return 'Remove Thread';
		    	break;
	    }
    }

	public function getAdditionalFormated($additional)
	{
		if ($this->isJSON($additional)) {
			$html = '';
			$parse = json_decode($additional, true);

			if (isset($parse['amount'])) {
				$html = '<span class="label label-primary">Amount: ' . $parse['amount'] . '</span><br>';
			}

			if (isset($parse['username'])) {
				$html .= '<span class="label label-primary">Username: ' . $parse['username'] . '</span><br>';
			}

			if (isset($parse['commission'])) {
				$html .= '<span class="label label-primary">Commission: ' . $parse['commission'] . '</span><br>';
			}

			if (isset($parse['text'])) {
				$html .= '<span class="label label-primary">' . $parse['text'] . '</span><br>';
			}

			return $html;
		} else {
			return $additional;
		}
    }

    private function isJSON($string){
	    return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }
}
