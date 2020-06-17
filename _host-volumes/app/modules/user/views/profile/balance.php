<?php
/**
 * @var $dataProvider
 */

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<!-- HEADER -->
<header class="flex-center">
	<?= IconMenuWidget::widget() ?>
	<h2>Баланс: <?= Yii::$app->user->identity->formatBalance ?></h2>


	<?= MenuWidget::widget() ?>
</header>
<!-- HEADER FIN -->

<section>
	<div class="mainContainer"
		<div class="list-group">
			<?= Html::a('Пополнить', '#', ['class' => 'list-group-item']) ?>
			<?= Html::a('Вывести', '#', ['class' => 'list-group-item']) ?>
		</div>
		<div class="user-form">
			<?=
			GridView::widget([
				'dataProvider' => $dataProvider,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
					[
						'attribute' => 'type',
						'format' => 'html',
						'value' => function($data){
							return $data->getNameType($data->type);
						}
					],
					[
						'attribute' => 'additional',
						'format' => 'html',
						'value' => function($data){
							return $data->getAdditionalFormated($data->additional);
						}
					],
					[
						'attribute' => 'created_at',
						'format' => 'text',
						'value' => function($data){
							return Yii::$app->formatter->asDatetime($data->created_at);
						}
					]
				],
			]);
			?>
			<p>&nbsp;<br><br></p>
		</div>
	</div>
</section>
