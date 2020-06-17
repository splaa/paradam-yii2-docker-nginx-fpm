<?php

namespace app\components\widgets\navigation;

use Yii;
use yii\base\Widget;

class NavigationWidget extends Widget
{
	public function run()
	{
		$active = '';
		$route = Yii::$app->getUrlManager()->parseRequest(Yii::$app->request);
		
		if (!empty($route)) {
			$parse = array_shift($route);
			$explode = explode('/', $parse);

			if (!empty($explode)) {
				$active = array_shift($explode);
			}
		}

		return $this->render('navigation', [
			'active' => $active
		]);
	}
}