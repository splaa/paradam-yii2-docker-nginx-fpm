<?php

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use yii\widgets\ActiveForm;

?>

<!-- HEADER -->
<header class="flex-center">
	<?= IconMenuWidget::widget() ?>
	<h2>Изменить Аватар</h2>


	<?= MenuWidget::widget() ?>
</header>
<!-- HEADER FIN -->

<section>
	<div class="mainContainer">
		<img src="<?= Yii::$app->user->identity->avatarBig ?>" alt="<?= Yii::$app->user->identity->alt ?>" />

		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

		<?= $form->field($model, 'file')->fileInput() ?>

		<button>Отправить</button>

		<?php ActiveForm::end() ?>
	</div>
</section>
