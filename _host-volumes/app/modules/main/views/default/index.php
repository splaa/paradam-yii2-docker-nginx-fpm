<?php
	
	/* @var $this yii\web\View */
	
	$this->title = Yii::$app->name;

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
?>


<!-- HEADER -->
<header class="flex-center">
	<?= IconMenuWidget::widget() ?>
	<h2>Главная</h2>


	<?= MenuWidget::widget() ?>
</header>
<!-- HEADER FIN -->

<section>
	<div class="mainContainer">
		<div class="discover_header">
			<h2>Explore and set up</h2>
		</div>

		<div class="discoverButtons flex-between">
			<a href="" class="db_faq">
				<div class="dbf_bg">
					<span>FAQ</span>
				</div>
			</a>
			<a href="" class="db_setup">
				<div class="dbs_bg">
					<span>Let's set up profile</span>
				</div>
			</a>
		</div>
	</div>
</section>
