<?php
use himiklab\yii2\recaptcha\ReCaptcha2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
	'id' => 'form_step_1',
	'action' => \yii\helpers\Url::to(['/user/register/step1']),
	'options' => [
		'class' => 'registration__form',
	],
	'fieldConfig' => [
		'template' => "{input}\n<div>{error}</div>",
		'labelOptions' => ['class' => ''],
		'options' => []
	],
]); ?>
	<div class="tabs registration__tabs">
		<div class="tabs__control">
			<div class="tabs__item tabs__item_active" data-type="telegram">
				КОД В ТЕЛЕГРАМ
			</div>
			<div class="tabs__item" data-type="call">
				ЗВОНОК НА НОМЕР
			</div>
		</div>
		<div class="registration__inputWrapper">
			<div class="inputTelCode">
				<input type="hidden" name="type" value="telegram" />
				<?= $form->field($model, 'telephone')->textInput([
						'autofocus' => true,
						'type' => 'tel',
						'class' => 'inputTelCode__input',
						'placeholder' => 'Номер телефона, имя пользователя или эл.почта'
				])->label(false) ?>
			</div>
		</div>
	</div>
	<div class="registration__wrapper">
		<?= $form->field($model, 'reCaptcha')->widget(ReCaptcha2::className()) ?>
		<div class="registration__control">
			<?= Html::submitButton('Дальше', [
				'class' => 'pButton actionValidate',
			]) ?>
		</div>
	</div>
	<div class="loginForm__registrationLink">
		<span>Уже имею учетную запись!</span>
		<?= Html::a('Ввойти', ['/user/default/login'], ['class' => '']) ?>
	</div>
<?php ActiveForm::end(); ?>