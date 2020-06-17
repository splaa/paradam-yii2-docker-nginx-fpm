<?php

	namespace app\modules\services\controllers;

	use app\modules\services\models\Question;
	use app\modules\services\models\QuestionSearch;
	use app\modules\services\models\Service;
	use app\modules\services\models\ServiceQuestion;
	use app\modules\user\controllers\UserController;
	use Yii;
	use yii\filters\VerbFilter;
	use yii\helpers\Url;
	use yii\web\NotFoundHttpException;

	/**
	 * QuestionController implements the CRUD actions for Question model.
	 */
	class QuestionController extends UserController
	{


		/**
		 * {@inheritdoc}
		 */
		public function behaviors()
		{
			return yii\helpers\ArrayHelper::merge(parent::behaviors(), [
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
				],
			]);
		}

		/**
		 * Lists all Question models.
		 * @return mixed
		 */
		public function actionIndex()
		{
			$searchModel = new QuestionSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}

		/**
		 * Displays a single Question model.
		 * @param integer $id
		 * @return mixed
		 * @throws NotFoundHttpException if the model cannot be found
		 */
		public function actionView($id)
		{
			return $this->render('view', [
				'model' => $this->findModel($id),
			]);
		}

		/**
		 * Creates a new Question model.
		 * If creation is successful, the browser will be redirected to the 'view' page.
		 * @return mixed
		 */
		public function actionCreate()
		{

			$model = new Question();


			if (Yii::$app->request->post('Question')) {
				$questions = Yii::$app->request->post('Question')['questions'];

				foreach ($questions as $question) {
					$questionModel = new Question();
					$questionModel->question = $question;
					$questionModel->convention = 1;
					$questionModel->save();
				}
				return $this->redirect('/services/question');
			}

			$this->view->blocks['hideNavigationBar'] = true;

			return $this->render('create', [
				'model' => $model,
			]);
		}

		public function actionAddQuestion($id)
		{
			$service = Service::findOne($id);
			$model = new Question();

			if (Yii::$app->request->post('Service')) {
				$questions = Yii::$app->request->post('Service')['questions'];
				Yii::$app->db->createCommand()->delete('service_question', ['service_id' => $id])->execute();

				foreach ($questions as $question) {
					$questionModel = new Question();
					$questionModel->question = $question;
					$questionModel->convention = 1;
					$questionModel->save();

					$serviceQuestions = new ServiceQuestion();
					$serviceQuestions->service_id = $id;
					$serviceQuestions->question_id = $questionModel->id;
					$serviceQuestions->save();

				}

				return $this->redirect(['/services/service/view', 'id' => $id]);

			}

			$this->view->blocks['hideNavigationBar'] = true;

			return $this->render('create', [
				'service' => $service,
				'model' => $model,
				'back' => Url::to(['/services/service/update', 'id' => $id])
			]);


		}

		/**
		 * Updates an existing Question model.
		 * If update is successful, the browser will be redirected to the 'view' page.
		 * @param integer $id
		 * @return mixed
		 * @throws NotFoundHttpException if the model cannot be found
		 */
		public function actionUpdate($id)
		{

			$model = $this->findModel($id);

			if (Yii::$app->request->post('Question')) {
				$questions = Yii::$app->request->post('Question')['questions'];

				foreach ($questions as $question) {
					$model->question = $question;
					$model->convention = 1;
					$model->save();
				}
				return $this->redirect(['view', 'id' => $model->id]);
			}

			$this->view->blocks['hideNavigationBar'] = true;

			return $this->render('update', [
				'model' => $model,
			]);
		}

		/**
		 * Deletes an existing Question model.
		 * If deletion is successful, the browser will be redirected to the 'index' page.
		 * @param integer $id
		 * @return mixed
		 * @throws NotFoundHttpException if the model cannot be found
		 * @throws \Throwable
		 * @throws \yii\db\StaleObjectException
		 */
		public function actionDelete($id)
		{
			$this->findModel($id)->delete();

			return $this->redirect(['index']);
		}

		/**
		 * Finds the Question model based on its primary key value.
		 * If the model is not found, a 404 HTTP exception will be thrown.
		 * @param integer $id
		 * @return Question the loaded model
		 * @throws NotFoundHttpException if the model cannot be found
		 */
		protected function findModel($id)
		{
			if (($model = Question::findOne($id)) !== null) {
				return $model;
			}

			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
		}
	}
