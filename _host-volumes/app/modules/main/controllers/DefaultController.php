<?php

	namespace app\modules\main\controllers;

	use app\modules\user\controllers\UserController;
	use Yii;

	/**
	 * Default controller for the `main` module
	 */
	class DefaultController extends UserController
	{
		/**
		 * Renders the index view for the module
		 * @return string
		 */
		public function actionIndex()
		{
			return $this->render('index');
		}
		
		public function actionError()
		{
			$message = Yii::$app->errorHandler->exception->getMessage();

			return $this->render('error', ['message' => $message]);
		}
	}
