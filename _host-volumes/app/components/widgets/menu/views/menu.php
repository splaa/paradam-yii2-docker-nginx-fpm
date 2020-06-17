<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- LEFT MENU -->
<input type="checkbox" id="nav-toggle" hidden>
<nav class="nav">
	<label for="nav-toggle" class="nav-toggle" onclick></label>
	<?php if (!Yii::$app->user->isGuest): ?>
		<div class="nav_header">
			<h2>Акаунт</h2>
		</div>
		<div class="nav_menu_block">
			<div class="nm_profile">
				<div class="nm_top flex" onclick="window.location.href='<?= Url::to(Yii::$app->user->identity->username, ['public/', 'username' => Yii::$app->user->identity->username]) ?>';">
					<div class="nm_avatar">
						<img src="<?= Yii::$app->user->identity->avatarSmall ?>" alt="<?= Yii::$app->user->identity->username ?>">
					</div>
					<div class="nm_info">
						<span><?= Yii::$app->user->identity->first_name ?> <?= Yii::$app->user->identity->last_name ?></span>
						<p><?= Yii::$app->user->identity->username ?></p>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="nav_menu_list">
		<ul>
			<li>
                <span>
                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
                </span>
				<a href="<?= Yii::$app->homeUrl ?>">Главная</a>
			</li>
			<?php if (Yii::$app->user->isGuest): ?>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['login']) ?>"><?= Yii::t('app', 'NAV_LOGIN') ?></a>
				</li>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['register']) ?>"><?= Yii::t('app', 'NAV_SIGNUP') ?></a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php if (!Yii::$app->user->isGuest): ?>
		<div class="nav_menu_list">
			<ul>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['/user/profile/index']) ?>"><?= Yii::t('app', 'NAV_PROFILE') ?></a>
				</li>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['/user/profile/balance']) ?>"><?=  sprintf(Yii::t('app', 'NAV_PROFILE_BALANCE'), Yii::$app->user->identity->formatBalance, Yii::$app->user->identity->convertBalanceToUSD) ?></a>
				</li>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['/services/service']) ?>"><?= Yii::t('app', 'NAV_SERVICES') ?></a>
				</li>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['/services/question']) ?>"><?= Yii::t('app', 'NAV_QUESTIONS') ?></a>
				</li>
			</ul>
		</div>
	<?php endif; ?>
	<?php if (Yii::$app->user->can('admin')): ?>
		<div class="nav_menu_list">
			<ul>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['/admin/default/index']) ?>"><?= Yii::t('app', 'NAV_ADMIN') ?></a>
				</li>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['/admin/users/index']) ?>"><?= Yii::t('app', 'ADMIN_USERS') ?></a>
				</li>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['/admin/thread/index']) ?>"><?= Yii::t('app', 'ADMIN_THREAD') ?></a>
				</li>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<a href="<?= Url::to(['/admin/order-service/index']) ?>"><?= Yii::t('app', 'ADMIN_ORDERS') ?></a>
				</li>
			</ul>
		</div>
	<?php endif; ?>


	<?php if (!Yii::$app->user->isGuest): ?>
		<div class="nav_menu_list">
			<ul>
				<li>
	                <span>
	                    <img src="<?= Yii::getAlias('@web') ?>/images/paradam/rectangle.png" alt="">
	                </span>
					<?= Html::a(Yii::t('app', 'NAV_LOGOUT'), ['/user/default/logout'], [
							'data' => [
								'method' => 'post'
							],
							['class' => '']
						]
					);?>
				</li>
			</ul>
		</div>
	<?php endif; ?>
</nav>
<!-- LEFT MENU -->

<!-- CONTENT FADER -->
<div class="mask-content"></div>