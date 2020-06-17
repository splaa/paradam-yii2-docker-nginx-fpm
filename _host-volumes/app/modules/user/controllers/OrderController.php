<?php

	namespace app\modules\user\controllers;

	use app\components\Hash;
	use app\modules\message\models\Message;
	use app\modules\message\models\Thread;
	use app\modules\message\models\UserMessage;
	use app\modules\message\models\UserThread;
	use app\modules\services\models\OrderService;
	use app\modules\services\models\Service;
	use app\modules\user\models\User;
	use Yii;
	use yii\filters\AccessControl;
	use yii\filters\VerbFilter;
	use yii\helpers\Json;
	use yii\helpers\Url;
	use yii\web\Controller;

	class OrderController extends UserController
	{
		public $layout = false;

		public function actionIndex($id = null)
		{
			if ($id) {
				$id = Yii::$app->request->get('id');
				$user_id = Yii::$app->request->get('user_id');
				$service = Service::findOne($id);

				if (empty($service)) return false;

				return $this->render('order-modal', compact('service', 'user_id'));
			}

		}

		public function actionPreview($id = null)
		{
			if ($id) {
				$id = Yii::$app->request->get('id');
				$user_id = Yii::$app->request->get('user_id');
				$service = Service::findOne($id);

				if (empty($service)) return false;

				return $this->render('order-preview', compact('service', 'user_id'));
			}

		}

		public function actionSave() {
			if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
				if (Yii::$app->user->isGuest) {
					return Json::encode([
						'error' => 'Авторизируйтесь или ввойдите'
					]);
				} else {
					$sender_id = Yii::$app->user->id;
					$recipient_id = Yii::$app->request->post('user_id');
					$service = Yii::$app->request->post('answered');
					$comment = Yii::$app->request->post('comment');
					$terms_of_use = Yii::$app->request->post('terms_of_use');

					if ($recipient_id && $service) {
						$service_id = array_key_first($service);
						$service_info = Service::findOne($service_id);

						if (User::validateSendMessage($sender_id, $recipient_id, 0, $service_info->price)) {
							$questions_ids = $service[$service_id] ?? [];
							$text = $this->createMessage($service_info, $questions_ids, $comment);

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

							$order = new OrderService();
							$order->customer_id = $sender_id;
							$order->executor_id = $recipient_id;
							$order->service_id = $service_id;
							$order->answers = $text['json'];
							$order->comment = $comment;
							$order->amount = $service_info->price;
							$order->save();

							$message = new Message();
							$message->author_id = $sender_id;
							$message->thread_id = $thread_id;
							$message->order_service_id = $order->id;
							$message->text = $text['html'];
							$message->save();

							$user_message = new UserMessage();
							$user_message->user_id = $sender_id;
							$user_message->message_id = $message->id;
							$user_message->save();

							// Minus from balance
							User::transferBits($sender_id, $recipient_id, User::TRANSFER_TYPE_SERVICE, $service_info->price, 1);

							$hash = new Hash();
							$hash->string = $thread_id;

							Yii::$app->getSession()->setFlash('success', 'Спасибо! Услуга заказана ожидайте ответ исполнителя.');

							return Json::encode([
								'redirect' => Url::to(['/message/message/view', 'id' => $hash->run(Hash::ENCODE)])
							]);
						} else {
							return Json::encode([
								'error' => 'На счету не достаточно средств пожалуйста пополните Ваш баланс.'
							]);
						}
					}
				}
			}
		}

		/**
		 * @param Service $service
		 * @param $question_ids
		 * @param string $comment
		 * @return array
		 */
		private function createMessage($service, $question_ids, $comment = '') {
			$json = [];
			$html = '<span class="service__title">===' . $service->name . '===</span>';

			if ($service->questions) {
				foreach ($service->questions as $key => $question) {
					if (!empty($question_ids[$question->id])) {
						$json[] = $question->question . ':' . $question_ids[$question->id];
						$html .= '<span class="service__question">' . ($key+1) . ') ' . $question->question . ' - ' . $question_ids[$question->id] . '</span>';
					}
				}
			}

			if (!empty($comment)) {
				$html .= '<span class="service__comment">Коментарий - ' . $comment . '</span>';
			}

			return [
				'html' => $html,
				'json' => Json::encode($json)
			];
		}
	}