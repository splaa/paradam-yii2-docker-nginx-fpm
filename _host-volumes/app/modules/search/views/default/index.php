<?php

use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<!-- HEADER -->
<header class="noborder">
	<div class="headerContainer">
		<a class="backButton" onclick="main.back()">
			<img src="<?= Yii::getAlias( '@web' ) ?>/images/paradam/back_arrow.svg" alt="">
		</a>

		<div class="headerUsers">
			<div class="messages_search">
				<input type="search" id="search" placeholder="Введите имя/username пользователя">
			</div>
		</div>

	</div>
</header>
<!-- HEADER FIN -->

<section class="usersContainer">
	<div class="tabs usersContainer__tabs">
		<div class="tabs__control usersContainer__tabsControl">
			<div class="tabs__item_click tabs__item tabs__item_small tabs__item_active" data-tab="#users">
				Люди
			</div>
			<div class="tabs__item_click tabs__item tabs__item_small" data-tab="#services">
				Услуги
			</div>
		</div>

		<div class="tabs__container usersContainer__tabsContent" style="display: block;" id="users">
			<?=
				ListView::widget([
					'dataProvider' => $dataProvider,
					'itemView' => '_users',
					'itemOptions' => ['tag' => null],
					'options' => [
						'id' => 'list_search'
					],
					'emptyText' => $this->render('_users_not_found'),
					'layout' => "{items}",
				]);
			?>
		</div>
		<div class="tabs__container usersContainer__tabsContent" id="services"></div>
	</div>
</section>
