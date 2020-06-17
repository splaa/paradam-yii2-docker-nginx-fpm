<?php

namespace app\modules\services\controllers;

use app\modules\services\models\ServiceQuestion;
use app\modules\services\models\ServiceQuestionSearch;
use app\modules\user\controllers\UserController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * ServiceQuestionController implements the CRUD actions for ServiceQuestion model.
 */
class ServiceQuestionController extends UserController
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
     * Lists all ServiceQuestion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render("index", [
	        'searchModel' => $searchModel,
	        'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ServiceQuestion model.
     * @param integer $service_id
     * @param integer $question_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($service_id, $question_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($service_id, $question_id),
        ]);
    }

    /**
     * Creates a new ServiceQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ServiceQuestion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'service_id' => $model->service_id, 'question_id' => $model->question_id]);
        }

	    return $this->render("//" . 'create', [
		    'model' => $model,
	    ]);
    }

    /**
     * Updates an existing ServiceQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $service_id
     * @param integer $question_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($service_id, $question_id)
    {
        $model = $this->findModel($service_id, $question_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'service_id' => $model->service_id, 'question_id' => $model->question_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	/**
	 * Deletes an existing ServiceQuestion model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $service_id
	 * @param integer $question_id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
    public function actionDelete($service_id, $question_id)
    {
        $this->findModel($service_id, $question_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ServiceQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $service_id
     * @param integer $question_id
     * @return ServiceQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($service_id, $question_id)
    {
        if (($model = ServiceQuestion::findOne(['service_id' => $service_id, 'question_id' => $question_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
