<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use yii\helpers\Html;
?>

<?php if (Yii::$app->user->isGuest) : ?>
	<header class="loginHeader">
		<h2>Paradam,</h2>
	</header>
<?php else: ?>
	<!-- HEADER -->
	<header class="flex-center">
		<?= IconMenuWidget::widget() ?>
		<h2>Ошибка</h2>


		<?= MenuWidget::widget() ?>
	</header>
	<!-- HEADER FIN -->
<?php endif; ?>

<section class="mainContainer">
	<div class="loginForm">
		<div class="alert alert-danger">
			<?= nl2br(Html::encode($message)) ?>
		</div>
	</div>
</section>
