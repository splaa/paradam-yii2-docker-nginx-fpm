<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php
	$form = ActiveForm::begin([
		'id' => 'form_step_3',
		'action' => \yii\helpers\Url::to(['/user/register/step3']),
		'options' => [
			'class' => 'registration__form',
		],
		'fieldConfig' => [
			'template' => "{input}\n<div>{error}</div>",
			'labelOptions' => ['class' => ''],
			'options' => [
			]
		],
	]);
?>
	<h3 class="registration__title">Введите имя, фамилию и пароль</h3>
	<div class="registration__description">
		Добавьте свое имя, что б друзья могли найти вас
	</div>
	<div class="registration__inputWrapper">
		<?= $form->field($model, 'first_name')->textInput([
			'autofocus' => true,
			'class' => '',
			'placeholder' => 'Имя'
		])->label(false) ?>
	</div>
	<div class="registration__inputWrapper">
		<?= $form->field($model, 'last_name')->textInput([
			'class' => '',
			'placeholder' => 'Фамилия'
		])->label(false) ?>
	</div>
	<div class="registration__inputWrapper">
		<?= $form->field($model, 'email')->textInput([
			'class' => '',
			'type' => 'email',
			'placeholder' => 'Email'
		])->label(false) ?>
	</div>
	<div class="registration__inputWrapper">
		<?= $form->field($model, 'username')->textInput([
			'class' => '',
			'placeholder' => 'Ваш логин'
		])->label(false) ?>
	</div>
	<div class="registration__inputWrapper">
		<?= $form->field($model, 'password')->passwordInput([
			'class' => '',
			'placeholder' => 'Пароль'
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