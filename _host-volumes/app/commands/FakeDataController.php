<?php


namespace app\commands;

use app\modules\user\models\User;
use Faker\Factory;
use yii\base\Exception;
use yii\helpers\Console;

class FakeDataController extends \yii\console\Controller
{
	/**
	 * @param int $count
	 */
	public function actionGenerate($count = 20)
	{
		for ($i = 1; $i <= $count; $i++) {
			$faker = Factory::create();
			$user = new User();

			$user->username = $faker->userName;
			$user->email = $faker->email;
			$user->first_name = $faker->firstName;
			$user->last_name = $faker->lastName;
			$user->telephone = $faker->phoneNumber;
			$user->status = User::STATUS_ACTIVE;
			try {
				$user->setPassword('123321');
				$user->save();

				$this->stderr($user->username . PHP_EOL, rand(Console::FG_BLACK, Console::FG_GREY));
			} catch (Exception $e) {
				$this->stderr($e, Console::FG_RED, Console::UNDERLINE);
			}
		}
	}
}