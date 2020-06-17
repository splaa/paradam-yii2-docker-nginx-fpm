<?php

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<!-- HEADER -->
<header class="flex-center">
	<?= IconMenuWidget::widget() ?>
	<h2>Список пользователей</h2>


	<?= MenuWidget::widget() ?>
</header>
<!-- HEADER FIN -->

<section>
	<div class="mainContainer">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				[
					'attribute' => 'username',
					'format' => 'raw',
					'value' => function($data) {
						return Html::a($data->username, ['public/', 'username' => $data->username]);
					}
				],
			],
		]) ?>
		<p>&nbsp;<br><br></p>
	</div>
</section>
