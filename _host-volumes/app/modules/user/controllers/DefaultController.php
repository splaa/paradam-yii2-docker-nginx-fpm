<?php

	namespace app\modules\user\controllers;
	
	
	use app\modules\user\forms\EmailConfirmForm;
    use app\modules\user\forms\LoginForm;
    use app\modules\user\forms\PasswordResetForm;
    use app\modules\user\forms\PasswordResetRequestForm;
    use app\modules\user\forms\PhoneLoginForm;
    use app\modules\user\forms\SignupForm;
    use app\modules\user\Module;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;

	class DefaultController extends UserController
	{
		/**
		 * @var Module
		 */
		public $module;
		
		public function actions()
		{
			return [
				'captcha' => [
					'class' => 'yii\captcha\CaptchaAction',
					'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
				],
			];
		}
		
		public function actionIndex()
		{
			return $this->redirect(['profile/index'], 301);
		}
		
		public function actionLogin()
		{
			if (!Yii::$app->user->isGuest) {
				return $this->goHome();
			}

			$model = new PhoneLoginForm();

			if ($model->load(Yii::$app->request->post()) && $model->login()) {
				return $this->redirect(['/main/default']);
			} else {
				$show_captcha = false;
				if (Yii::$app->request->isPost) {
					if (Yii::$app->session->get('loginCount')) {
						if (Yii::$app->session->get('loginCount') >= PhoneLoginForm::LOGIN_COUNT_LIMIT) {
							$show_captcha = true;
						} else {
							Yii::$app->session->set('loginCount', Yii::$app->session->get('loginCount') + 1);
						}
					} else {
						Yii::$app->session->set('loginCount', 1);
					}
				}

				$this->view->blocks['hideNavigationBar'] = true;

				return $this->render('login', [
					'model' => $model,
					'show_captcha' => $show_captcha
				]);
			}
		}

		public function actionForgotten()
		{
			if (!Yii::$app->user->isGuest) {
				return $this->goHome();
			}

			$this->view->registerJsFile('@web/js/phone-codes.js');

			$model = new PhoneLoginForm();

			if ($model->load(Yii::$app->request->post()) && $model->login()) {
				return $this->goBack();
			} else {
				$show_captcha = false;
				if (Yii::$app->request->isPost) {
					if (Yii::$app->session->get('loginCount')) {
						if (Yii::$app->session->get('loginCount') >= PhoneLoginForm::LOGIN_COUNT_LIMIT) {
							$show_captcha = true;
						} else {
							Yii::$app->session->set('loginCount', Yii::$app->session->get('loginCount') + 1);
						}
					} else {
						Yii::$app->session->set('loginCount', 1);
					}
				}

				$this->view->blocks['hideNavigationBar'] = true;

				return $this->render('forgotten', [
					'model' => $model,
					'show_captcha' => $show_captcha
				]);
			}
		}
		
		public function actionLogout()
		{
			Yii::$app->user->logout();
			
			return $this->goHome();
		}
	}