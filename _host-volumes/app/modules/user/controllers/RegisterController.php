<?php

	namespace app\modules\user\controllers;

	use app\components\Smsc;
	use app\components\Telegram;
	use app\modules\user\forms\RegisterForm;
	use Yii;
	use yii\filters\VerbFilter;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\Controller;
	use yii\base\ErrorException;

	/**
	 * RegisterController implements the CRUD actions for User model.
	 */
	class RegisterController extends Controller
	{
		/**
		 * {@inheritdoc}
		 */
		public function behaviors()
		{
			return [
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
				],
			];
		}
		
		/**
		 * Lists all User models.
		 * @return mixed
		 * @throws \yii\base\Exception
		 */
		public function actionIndex()
		{
			$this->view->blocks['hideNavigationBar'] = true;

			return $this->render('index', [
				'step_1' => $this->actionStep1(),
				'step_2' => $this->actionStep2(),
				'step_3' => $this->actionStep3(),
				'step_4' => $this->actionStep4(),
			]);
		}

		public function actionStep1() {
			$model = new RegisterForm();
			$model->scenario = RegisterForm::SCENARIO_STEP_1;

			$result = $this->checkData($model);
			if (Yii::$app->request->isAjax) {
				$convert = $result->data ?? [];

				if (isset($convert['success']) && Yii::$app->request->post('type')) {
					switch (Yii::$app->request->post('type')) {
						case 'telegram':
							$code = Yii::$app->security->generateRandomString(4);
							// Send Message to telegram
							$telegram = new Telegram($model->telephone, 'Код для авторизации: ' . $code);
							$telegram->message();
							$text = 'Введите код, отправленый в Telegram ' . $model->telephone . ' <a href="' . Url::to(['/user/register']) . '">Изменить номер</a> или <a href="#">Отправить код в Telegram еще раз</a>';
							break;
						case 'call':
							// Send Call Message to User Phone
							$smsc = new Smsc($model->telephone);
							$code = $smsc->call();
							$text = 'Введите последние 4 цифры, номера с которого мы звоним на ' . $model->telephone . ' <a href="' . Url::to(['/user/register']) . '">Изменить номер</a> или <a href="#">Отправить SMS еще раз</a>';
							break;
						default:
							$code = 0;
							$text = '';
							break;
					}

					if ($code) {
						Yii::$app->session->set('codeAuth', $code);
					}

					$result = $this->asJson([
						'success' => true,
						'text' => $text
					]);
				}
			}

			return $result;
		}

		public function actionStep2() {
			$model = new RegisterForm();
			$model->scenario = RegisterForm::SCENARIO_STEP_2;

			return $this->checkData($model);
		}

		public function actionStep3() {
			$model = new RegisterForm();
			$model->scenario = RegisterForm::SCENARIO_STEP_3;

			$result = $this->checkData($model);

			if (Yii::$app->request->isAjax) {
				$convert = $result->data ?? [];

				if (isset($convert['success'])) {
					// Get Steps
					$step_1 = json_decode(Yii::$app->session->get(RegisterForm::SCENARIO_STEP_1), true);
					$step_2 = json_decode(Yii::$app->session->get(RegisterForm::SCENARIO_STEP_2), true);
					$step_3 = json_decode(Yii::$app->session->get(RegisterForm::SCENARIO_STEP_3), true);

					// Data for model
					$data = [];

					// Check if we have all needed data from session
					if (!empty($step_1['RegisterForm']) && !empty($step_2['RegisterForm']) && !empty($step_3['RegisterForm'])) {
						$data['RegisterForm'] = [];

						foreach ($step_1['RegisterForm'] as $key => $item) {
							$data['RegisterForm'][$key] = $item;
						}

						foreach ($step_2['RegisterForm'] as $key => $item) {
							$data['RegisterForm'][$key] = $item;
						}

						foreach ($step_3['RegisterForm'] as $key => $item) {
							$data['RegisterForm'][$key] = $item;
						}
					}

					try {
						if ($data && $model->load($data) && $model->save()) {
							$text = '
						<h3 class="registration__title">Поздравляем в Paradam, ' . $model->username . '!</h3>
						<div class="registration__description">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
							<div class="registration__inputWrapper">
								<a href="' . Url::to(['/user/default/phonelogin']) . '">Изменить имя пользователя</a>
							</div>
						</div>';

							$result = $this->asJson([
								'success' => true,
								'text' => $text
							]);
						} else {
							$result = $this->asJson([
								'error' => 'Регистрация в данный момент не доступна. Мы уже занимаемся данным вопросом!',
							]);
						}
					} catch (ErrorException $e) {
						$result = $this->asJson([
							'error' => 'Регистрация в данный момент не доступна. Мы уже занимаемся данным вопросом!',
						]);
					}
				}
			}

			return $result;
		}

		public function actionStep4() {
			$model = new RegisterForm();
			$model->scenario = RegisterForm::SCENARIO_STEP_4;

			return $this->checkData($model);
		}

		/**
		 * @param RegisterForm $model
		 * @return string
		 */
		private function checkData(&$model) {
			if (Yii::$app->request->isAjax) {
				if ($model->load(Yii::$app->request->post()) && $model->validate()) {
					Yii::$app->session->set($model->scenario, json_encode(Yii::$app->request->post()));

					return $this->asJson([
						'success' => true
					]);
				}

				$result = [];
				foreach ($model->getErrors() as $attribute => $errors) {
					$result[Html::getInputId($model, $attribute)] = $errors;
				}

				return $this->asJson([
					'validation' => $result
				]);
			}

			return $this->renderPartial($model->scenario, [
				'model' => $model
			]);
		}
	}
