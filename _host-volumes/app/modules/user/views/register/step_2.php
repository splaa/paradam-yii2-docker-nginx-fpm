<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php
	$form = ActiveForm::begin([
		'id' => 'form_step_2',
		'action' => \yii\helpers\Url::to(['/user/register/step2']),
		'options' => [
			'class' => 'registration__form',
		],
		'fieldConfig' => [
			'template' => "{input}\n<div>{error}</div>",
			'labelOptions' => ['class' => ''],
			'options' => []
		],
	]);
?>
	<h3 class="registration__title">Введите код подтверждения</h3>
	<div class="registration__description text"></div>
	<div class="registration__inputWrapper">
		<?= $form->field($model, 'verifyCodeTelephone')->textInput([
			'autofocus' => true,
			'class' => '',
			'placeholder' => 'Код подтверждения'
		])->label(false) ?>
	</div>
	<div class="registration__inputWrapper">
		<div class="registration__control">
			<?= Html::submitButton('Дальше', [
				'class' => 'pButton actionValidate',
			]) ?>
		</div>
	</div>
<?php ActiveForm::end(); ?>