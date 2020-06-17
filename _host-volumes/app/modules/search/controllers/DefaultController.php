<?php

namespace app\modules\search\controllers;

use app\modules\admin\models\UserSearch;
use app\modules\user\controllers\UserController;
use app\modules\user\models\User;
use yii\web\View;


/**
 * Default controller for the `search` module
 */
class DefaultController extends UserController
{
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

	    $searchModel = new UserSearch();
	    $dataProvider = $searchModel->get();

	    $this->view->registerJsFile('@web/js/search.js', ['depends' => 'yii\web\YiiAsset', 'position' => View::POS_END]);

	    return $this->render('index', [
		    'searchModel' => $searchModel,
		    'dataProvider' => $dataProvider,
	    ]);
    }

	public function actionQuery($q = null) {
		$view = '';
		$users = User::find()
			->select(['id'])
			->filterWhere(['like', 'username', $q])
			->orfilterWhere(['like', 'CONCAT(first_name, " ", last_name)', $q])
			->andFilterWhere(['status' => User::STATUS_ACTIVE])
			->limit(10)
			->asArray()
			->all();

		if ($users) {
			foreach ($users as $key => $user) {
				if (!empty($user['id'])) {
					$model = User::findOne($user['id']);

					$view .= $this->renderAjax('_users', [
						'model' => $model
					]);
				}
			}
		} else {
			$view = $this->renderAjax('_users_not_found');
		}

		return $view;
	}
}
