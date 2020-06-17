<?php

namespace app\modules\user\forms;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the uploads form.
 */
class UploadAvatar extends Model
{
	/**
	 * @var UploadedFile file attribute
	 */
	public $file;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['file'], 'file', 'extensions' => 'png, jpg, jpeg'],
		];
	}
}