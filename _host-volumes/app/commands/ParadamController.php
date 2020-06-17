<?php


namespace app\commands;

use app\modules\user\models\User;
use Faker\Factory;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\helpers\Console;
use yii\imagine\Image;
use YoHang88\LetterAvatar\LetterAvatar;

class ParadamController extends \yii\console\Controller
{
	/**
	 * @param bool $size
	 * @param bool $letter
	 */
	public function actionUserAvatarRegenerationSize($size, $letter = false)
	{
		try {
			$users = User::find()->all();

			foreach ($users as $user) {
				if ($letter && $size) {
					$name = $user->username;
					if (!empty($user->last_name)) {
						$name = $user->first_name . ' ' . $user->last_name;
					}

					$avatar = new LetterAvatar($name, 'square', $size);
					$avatar->saveAs(Yii::getAlias('web') . '/images/user/avatar/' . $user->id . '-' . $size . '.png');
				} elseif ($size) {
					if (file_exists(Yii::getAlias('web') . '/images/user/avatar/' . $user->id . '-' . User::SIZE_AVATAR_ORIGINAL . '.png')) {
						$file = Yii::getAlias('web') . '/images/user/avatar/' . $user->id . '-' . User::SIZE_AVATAR_ORIGINAL . '.png';
					} elseif (file_exists(Yii::getAlias('web') . '/images/user/avatar/' . $user->id . '-' . User::SIZE_AVATAR_ORIGINAL . '.jpg')) {
						$file = Yii::getAlias('web') . '/images/user/avatar/' . $user->id . '-' . User::SIZE_AVATAR_ORIGINAL . '.jpg';
					}

					if (!empty($file)) {
						Image::thumbnail($file, $size, $size)->save('images/user/avatar/' . Yii::$app->user->identity->getId() . '-' . $size . '.png');
					}
				}
			}

			$this->stderr('Изображения сгенерированы с размером: ' . $size . PHP_EOL, Console::FG_GREEN, Console::UNDERLINE);

		} catch (InvalidConfigException $e) {
			$this->stderr($e, Console::FG_RED, Console::UNDERLINE);
		}
	}
}