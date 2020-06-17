<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title = Yii::t('app', 'TITLE_CONTACT');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            <?= Yii::t('app', 'CONTACT_THANKS'); ?>
        </div>

        <p>
            Обратите внимание, что если вы включите отладчик Yii, вы сможете
            просмотреть почтовое сообщение на почтовой панели отладчика. <br>
			<?php if (Yii::$app->mailer->useFileTransport): ?>
                Поскольку приложение находится в режиме разработки, <br>
                электронная почта не отправляется, <br>
                но сохраняется как файл в
                <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>. <br>
                Пожалуйста, настройте
                <code>useFileTransport</code> свойство of the <code>mail</code> <br>
                application component должно быть false to enable email sending.
			<?php endif; ?>
        </p>
	
	<?php else: ?>

        <p>
            Если у вас есть деловые вопросы или другие вопросы,<br>
            Пожалуйста, заполните следующую форму, чтобы связаться с нами. <br>
            Thank you. <br>
        </p>

        <div class="row">
            <div class="col-lg-5">
				
				<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
				
				<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
				
				<?= $form->field($model, 'email') ?>
				
				<?= $form->field($model, 'subject') ?>
				
				<?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
				
				<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
					'captchaAction' => '/main/contact/captcha',
					'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
				]) ?>

                <div class="form-group">
					<?= Html::submitButton(Yii::t('app', 'BUTTON_SEND'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
				
				<?php ActiveForm::end(); ?>

            </div>
        </div>
	
	<?php endif; ?>
</div>
