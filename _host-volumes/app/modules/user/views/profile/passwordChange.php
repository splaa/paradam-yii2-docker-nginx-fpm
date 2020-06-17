<?php
// paradam.me.loc/passwordChange.php

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */


$this->title = Yii::t('app', 'TITLE_PASSWORD_CHANGE');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TITLE_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- HEADER -->
<header class="flex-center">
	<?= IconMenuWidget::widget() ?>
	<h2><?= Html::encode($this->title) ?></h2>


	<?= MenuWidget::widget() ?>
</header>
<!-- HEADER FIN -->

<section>
	<div class="mainContainer"
		<div class="user-form">

			<?php $form = ActiveForm::begin(); ?>

			<?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>
</section>