<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php
	$form = ActiveForm::begin([
		'id' => 'form_step_4',
		'action' => \yii\helpers\Url::to(['/user/register/step4']),
		'options' => [
			'class' => 'registration__form',
			'onsubmit' => 'submitValidation(this)'
		],
		'fieldConfig' => [
			'template' => "{input}\n<div>{error}</div>",
			'labelOptions' => ['class' => ''],
			'options' => [
			]
		],
	]);
?>
	<div class="text">
		<h3 class="registration__title">Поздравляем в Paradam, ИМЯ_ПОЛЬЗОВАТЕЛЯ!</h3>
		<div class="registration__description">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			<div class="registration__inputWrapper">
				<a href="<?= Url::to(['login']) ?>">Изменить имя пользователя</a>
			</div>
		</div>
	</div>
	<div class="registration__inputWrapper">
		<div class="registration__control">
			<?= Html::a('Ввойти', ['login'],
				[
					'class' => 'pButton actionValidate',
					'name' => 'signup-button'
				]) ?>
		</div>
	</div>
	<div class="registration__description">
		Регестрируясь, вы принимаете наши
		<a href="#" class="black">Условия, Политику использования данных</a> и <a href="#" class="black">Политику по файлов cookie</a>.
	</div>
<?php ActiveForm::end(); ?>