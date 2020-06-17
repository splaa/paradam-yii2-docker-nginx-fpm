<?php

namespace app\modules\message\controllers;

use app\modules\message\forms\MessageForm;
use app\modules\message\forms\SettingsForm;
use app\modules\message\models\Froze;
use app\modules\message\models\Message;
use app\modules\message\models\Thread;
use app\modules\message\models\UserMessage;
use app\modules\message\models\UserThread;
use app\modules\services\models\OrderService;
use app\modules\user\controllers\UserController;
use app\modules\user\models\User;
use Yii;
use \app\components\Hash;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\View;

/**
 * Default controller for the `message` module
 */
class MessageController extends UserController
{
	public function beforeAction($action)
	{
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	}

	/**
	 * @param string $id
	 * @return string
	 * @throws \yii\base\InvalidConfigException
	 */
	public function actionIndex()
	{
		$this->view->registerJsFile('@web/js/chat.js');

		$threads = UserThread::find()->joinWith('thread')
			->where(['user_id' => Yii::$app->user->id])
			->orderBy(['thread.updated_at' => SORT_DESC])
			->all();

		$selected_user_thread = [];
		$froze = 0;

		$model = new SettingsForm();

		return $this->render('index', [
			'model' => $model,
			'threads' => $threads,
			'froze' => $froze,
			'selected_user_thread' => $selected_user_thread
		]);
	}

	public function actionView($id = '')
	{
		$this->view->registerJsFile('@web/js/ws.js', ['depends' => 'yii\web\YiiAsset', 'position' => View::POS_END]);
		$this->view->registerJsFile('@web/js/recorder.js', ['depends' => 'yii\web\YiiAsset', 'position' => View::POS_END]);
		$this->view->registerJsFile('@web/js/record.js', ['depends' => 'yii\web\YiiAsset', 'position' => View::POS_END]);
		$this->view->registerJsFile('@web/js/chat.js', ['depends' => 'yii\web\YiiAsset', 'position' => View::POS_END]);

		$threads = UserThread::find()->joinWith('thread')
			->where(['user_id' => Yii::$app->user->id])
			->orderBy(['thread.updated_at' => SORT_DESC])
			->all();

		$selected_user_thread = [];
		$froze = 0;

		if ($id) {
			// Decode Hash
			$hash = new Hash();
			$hash->string = $id;

			$selected_user_thread = UserThread::find()
				->where(['thread_id' =>  $hash->run(Hash::DECODE)])
				->andWhere(['user_id' => Yii::$app->user->id])
				->one();

			if ($selected_user_thread) {
				$froze = Froze::find()->where(['thread_id' => $selected_user_thread->thread->id])->andWhere(['status' => 0])->count();

				$this->view->blocks['hideNavigationBar'] = true;
			}
		}

		return $this->render('thread', [
			'threads' => $threads,
			'froze' => $froze,
			'selected_user_thread' => $selected_user_thread
		]);
	}

	public function actionSettings()
	{
		$model = new SettingsForm();

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changeSmsCost()) {
			if (!Yii::$app->request->isPjax && !Yii::$app->request->isAjax) {
				Yii::$app->getSession()->setFlash('success', 'Спасибо! Стоимость сообщения изменена.');

				return $this->refresh();
			}
		}

		if (!Yii::$app->request->isPjax && !Yii::$app->request->isAjax) {
			return $this->render('settings', [
				'model' => $model
			]);
		}
	}

	public function actionCreate()
	{
		if (Yii::$app->request->isPost || Yii::$app->request->isAjax) {
			$model = new MessageForm();

			if ($model->load(Yii::$app->request->post()) && $model->validate()) {
				$sender_id = Yii::$app->user->id;
				$recipient_id = $model->user_id;

				if (User::validateSendMessage($sender_id, $recipient_id, 0)) {
					$text = $model->text;

					$thread = Thread::find()->alias('t')
						->innerJoin('user_thread as ut1', 't.id = ut1.thread_id')
						->innerJoin('user_thread as ut2', 't.id = ut2.thread_id')
						->where(['ut1.user_id' => $sender_id, 'ut2.user_id' => $recipient_id])
						->orWhere(['ut1.user_id' => $recipient_id, 'ut2.user_id' => $sender_id])
						->groupBy('t.id')
						->asArray()
						->one();

					if ($thread) {
						$thread_id = $thread['id'];
					} else {
						$thread = new Thread();
						$thread->title = $sender_id . '=>' . $recipient_id;
						$thread->creator_id = $recipient_id;
						$thread->save();
						$thread_id = $thread->id;

						$user_thread = new UserThread();
						$user_thread->user_id = $recipient_id;
						$user_thread->thread_id = $thread_id;
						$user_thread->save();

						$user_thread = new UserThread();
						$user_thread->user_id = $sender_id;
						$user_thread->thread_id = $thread_id;
						$user_thread->save();
					}

					if ($text) {
						$message = new Message();
						$message->author_id = $sender_id;
						$message->thread_id = $thread_id;
						$message->text = $text;
						$message->save();

						$user_message = new UserMessage();
						$user_message->user_id = $sender_id;
						$user_message->message_id = $message->id;
						$user_message->save();


						// Minus from balance
						if (mb_strlen($text, 'UTF-8') > USER::MESSAGE_LENGTH) {
							$factor = count(User::strSplitUnicode($text, USER::MESSAGE_LENGTH));
						} else {
							$factor = 1;
						}

						User::transferBits($sender_id, $recipient_id, User::TRANSFER_TYPE_SMS_FROZE, 0, $factor, false, $message->id, $thread_id);
					}

					$hash = new Hash();
					$hash->string = $thread_id;

					return $this->redirect(Url::to(['view', 'id' => $hash->run(Hash::ENCODE)]));
				} else {
					Yii::$app->getSession()->setFlash('error', 'На счету не достаточно средств пожалуйста пополните Ваш баланс.');
					return $this->redirect(Url::to(['/user/profile/balance']));
				}
			}
		} else {
			throw new NotFoundHttpException('Страница не найденна');
		}
	}

	public function actionUploadAudio()
	{
		if (Yii::$app->request->isPost) {
			$file = UploadedFile::getInstanceByName('audio_data');

			if ($file) {
				if (!file_exists(Yii::getAlias('@web') . 'uploads/messages')) {
					mkdir(Yii::getAlias('@web') . 'uploads/messages', 0777);
				}

				$file->saveAs(Yii::getAlias('@web') . 'uploads/messages/' . $file->name . '.wav');
			}
		}
	}

	public function actionConfirmTask()
	{
		if (Yii::$app->request->isPost) {
			$service_order_id = Yii::$app->request->post('order_id');
			$type = Yii::$app->request->post('type');

			$orderService = OrderService::findOne($service_order_id);

			if ($orderService && ($orderService->status != 2 || $orderService->status != 3)) {
				$orderService->status = $type;
				$orderService->save();

				if ($type == 2) {
					User::transferBits($orderService->executor_id, $orderService->customer_id, User::TRANSFER_TYPE_TRANSFER, $orderService->amount, 1);
				} elseif ($type == 3) {
					User::transferBits($orderService->customer_id, $orderService->executor_id, User::TRANSFER_TYPE_TRANSFER, $orderService->amount, 1, true);
				}

				return Json::encode([
					'success' => OrderService::getStatusByType($type)
				]);
			} else {
				return Json::encode([
					'error' => 'Не верный заказ'
				]);
			}
		}
	}

	public function actionSearch($q = null)
	{
		try {
			$sql = "SELECT t.creator_id,m.text, ut.`thread_id` , u.`id` , u.`username` AS `value` , CONCAT( u.first_name, ' ', u.last_name ) AS `full_name` FROM user_thread AS ut ";
			$sql .= "LEFT JOIN message AS m ON m.thread_id = ut.thread_id ";
			$sql .= "LEFT JOIN thread AS t ON t.id = ut.thread_id ";
			$sql .= "LEFT JOIN user AS u ON u.id = t.creator_id ";
			$sql .= "WHERE ut.user_id =1 AND (m.text LIKE :q OR CONCAT( u.first_name, ' ', u.last_name ) LIKE :q OR u.username LIKE :q)";
			$users = Yii::$app->db->createCommand($sql)->bindValue(':q', '%' . $q . '%')->queryAll();

			if ($users) {
				foreach ($users as $key => $user) {
					$path_to_file = Yii::getAlias( '@web' ).'images/user/avatar/' . $user['id'] . '-' . User::SIZE_AVATAR_SMALL . '.png';

					if(file_exists($path_to_file)){
						$avatar = Yii::$app->request->hostInfo . '/images/user/avatar/' . $user['id'] . '-' . User::SIZE_AVATAR_SMALL . '.png';
					} else {
						$avatar = Yii::$app->request->hostInfo . '/images/user/avatar/none.png';
					}

					$users[$key]['avatar'] = $avatar;

					$hash = new Hash();
					$hash->string = $user['thread_id'];

					$users[$key]['link'] = Url::to(['view', 'id' => $hash->run(Hash::ENCODE)]);
				}
			}
		} catch (InvalidConfigException $e) {
			$users = [];
		}

		return Json::encode($users);
	}
}
