<?php


namespace app\modules\user\controllers;


use app\modules\admin\models\UserSearch;
use app\modules\message\forms\MessageForm;
use app\modules\services\models\Service;
use app\modules\user\models\Subscribe;
use app\modules\user\models\User;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PublicController extends UserController
{
	public function actionIndex($username)
	{
		$model = User::findByUsername($username);

		if ($model) {
			$services = Service::find()->where(['user_id' => $model->id])->all();

			$messageForm = new MessageForm();

			if (Yii::$app->user->id != $model->id) {
				// Get ID record subscribe
				$subscriber_id = Yii::$app->user->id;
				$user_id = $model->id;

				$subscribe_info = Subscribe::checkSubscribe($user_id, $subscriber_id);
				$subscribe_id = $subscribe_info['subscribe_id'];
			} else {
				$subscribe_id = 0;
			}

			return $this->render('index', [
				'model' => $model,
				'services' => $services,
				'messageForm' => $messageForm,
				'subscribe_id' => $subscribe_id,
				'count' => Subscribe::find()->where(['user_id' => $model->id])->count()
			]);

		} else {
			throw new NotFoundHttpException('Страница не найденна');
		}
	}

	public function actionSubscribe()
	{
		if (!Yii::$app->user->isGuest) {
			if (Yii::$app->request->isAjax && Yii::$app->user->id != Yii::$app->request->post('user_id')) {
				// Get ID record subscribe
				$subscriber_id = Yii::$app->user->id;
				$user_id = Yii::$app->request->post('user_id');
				$subscribe_info = Subscribe::checkSubscribe($user_id, $subscriber_id);

				if (!$subscribe_info['subscribe_id']) {
					$subscribe = new Subscribe();
					$subscribe->subscriber_id = $subscriber_id;
					$subscribe->user_id = $user_id;
					$subscribe->save();

					$subscribe_id = $subscribe->id;
					$subscribe_info = Subscribe::checkSubscribe($user_id, $subscriber_id);
				} else {
					Subscribe::findOne($subscribe_info['subscribe_id'])->delete();
					$subscribe_id = 0;
					$subscribe_info = Subscribe::checkSubscribe($user_id, $subscriber_id);
				}

				return Json::encode([
					'html' => $this->renderAjax('__subscribe_btn_block', [
						'subscribe_id' => $subscribe_id
					]),
					'count' => $subscribe_info['count']
				]);
			}
		} else {
			return Json::encode([
				'login' => true
			]);
		}
	}
}