<?php
// paradam.me.loc/passwordChange.php

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */

?>
<!-- HEADER -->
<header class="flex-center">
	<?= IconMenuWidget::widget() ?>
	<h2>Изменить Link</h2>


	<?= MenuWidget::widget() ?>
</header>
<!-- HEADER FIN -->

<section>
	<div class="mainContainer"
		<div class="user-form">

			<?php $form = ActiveForm::begin(); ?>

			<?= $form->field($model, 'newLink')->textInput(['value' => Yii::$app->user->identity->link]) ?>

			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>
</section>