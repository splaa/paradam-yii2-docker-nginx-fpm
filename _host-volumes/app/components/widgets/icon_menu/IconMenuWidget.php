<?php
namespace app\components\widgets\icon_menu;

use yii\base\Widget;

class IconMenuWidget extends Widget
{
	public function run()
	{
		return $this->render('icon_menu');
	}
}