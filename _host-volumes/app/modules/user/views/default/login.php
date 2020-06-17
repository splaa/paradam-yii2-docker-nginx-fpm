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

<section class="mainContainer">
	<div class="loginForm">
		<?php $form = ActiveForm::begin([
			'id' => 'login-form',
			'options' => [
				'class' => 'loginForm__form',
			],
			'layout' => 'horizontal',
			'fieldConfig' => [
				'template' => "{input}\n<div>{error}</div>",
				'labelOptions' => ['class' => ''],
				'options' => [

				]
			],
		]); ?>
		<div class="loginForm__inputWrapper">
			<?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'class' => '', 'placeholder' => 'Номер телефону, имя пользователя или эл.почта'])->label(false) ?>
		</div>
		<div class="loginForm__inputWrapper">
			<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль', 'class' => ''])->label(false) ?>
		</div>
		<div class="restorePassword__linkWrapper loginForm__restorePassword">
			<?= Html::a('Забыли пароль?', ['forgotten'], ['class' => '']) ?>
		</div>

		<?php if ($show_captcha): ?>
			<div class="loginForm__inputWrapper">
				<?= $form->field($model, 'reCaptcha')->widget(ReCaptcha2::className(),[]) ?>
			</div>
		<?php endif; ?>

		<div class="loginForm__inputWrapper">
			<?= Html::submitButton('Ввойти', ['class' => 'pButton', 'name' => 'login-button']) ?>
		</div>
		<div class="loginForm__registrationLink">
			<span>Не имеете учетной записи?</span>
			<?= Html::a('Зарегестрируйтесь', ['/user/register'], ['class' => '']) ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</section>