<?php
// paradam.me.loc/passwordChange.php

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use app\widgets\Alert;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

?>
<!-- HEADER -->
<header class="flex-center">
	<?= IconMenuWidget::widget() ?>

	<h2><?= Html::encode($this->title) ?></h2>


	<?= MenuWidget::widget() ?>
</header>
<!-- HEADER FIN -->

<section>
	<div class="mainContainer">
		<?= Alert::widget() ?>

		<div class="user-form">

			<?php $form = ActiveForm::begin(); ?>

			<?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'telephone')->textInput(['value' => Yii::$app->user->identity->telephone]) ?>
			<?= $form->field($model, 'verifyCodeTelephone') ?>

			<div class="form-group">
				<div class="btn-group" role="group" aria-label="...">
					<?= Html::button('Телеграм', ['type' => 'button', 'class' => 'btn btn-primary confirm_btn', 'data-type' => 'telegram']) ?>
					<?= Html::button('Звонок', ['type' => 'button', 'class' => 'btn btn-primary confirm_btn', 'data-type' => 'call']) ?>
				</div>
			</div>

			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>
</section>

<?php
$url = Url::to(['phoneidentity/telephone-code-confirm']);
$js = <<< JS
$(document).ready(function() {
	$('.confirm_btn').click(function(){
		$.ajax({
			url: '{$url}',
			data: 'type=' + $(this).data('type') + '&telephone=' + $('#telephonechangeform-telephone').val(),
			type: 'POST',
			success: function (res) {
				console.log(res);
			},
			error: function () {}
		});
	})
	
});
JS;

$this->registerJs($js);

?>