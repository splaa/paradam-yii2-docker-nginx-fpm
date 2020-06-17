<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\modules\user\forms\LoginForm */

/* @var $show_captcha int */

use app\components\widgets\menu\MenuWidget;
use himiklab\yii2\recaptcha\ReCaptcha2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'PhoneLogin';
$this->params['breadcrumbs'][] = $this->title;
?>


<header class="loginHeader">
	<h2>Paradam,</h2>
</header>

<section class="mainContainer registration">
	<div class="loginForm">
		<?php $form = ActiveForm::begin([
			'id' => 'registrationForm',
			'layout' => 'horizontal',
			 'options' => [
				 'class' => 'registration__form',
             ],
			'fieldConfig' => [
				'template' => "{input}\n<div>{error}</div>",
				'labelOptions' => ['class' => ''],
				'options' => [
				]
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
						<div class="inputTelCode__selector">
							<div class="inputTelCode__label">
								UA +380
							</div>
							<div class="inputTelCode__dropdown"></div>
						</div>
						<input type="hidden" name="code" value="+380" />
						<input type="hidden" name="cc" value="UA" />
						<input type="hidden" name="type" value="telegram" />
						<?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'type' => 'tel', 'class' => 'inputTelCode__input', 'placeholder' => 'Номер телефона, имя пользователя или эл.почта'])->label(false) ?>
					</div>
				</div>
				<div class="restorePassword__linkWrapper loginForm__restorePassword">
					<?= Html::a('Вспомнили пароль?', ['login'], ['class' => '']) ?>
				</div>
			</div>
			<div class="registration__wrapper">
				<?php if ($show_captcha): ?>
						<?= $form->field($model, 'reCaptcha')->widget(ReCaptcha2::className(),[]) ?>
				<?php endif; ?>

				<div class="registration__control">
					<?= Html::submitButton('Получить пароль', ['class' => 'pButton', 'name' => 'login-button']) ?>
				</div>
			</div>
		<?php ActiveForm::end(); ?>

	</div>
</section>