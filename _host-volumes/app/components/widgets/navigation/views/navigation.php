<?php
/* @var $active string */

use yii\helpers\Url;

?>
<?php if (!isset($this->blocks['hideNavigationBar'])): ?>
	<section>
		<nav class="navigationBar">
			<ul>
				<li>
					<a href="<?= Yii::$app->homeUrl ?>">
						<img src="<?= Yii::getAlias('@web') ?>/images/paradam/discover<?= $active == 'discover' ? '-active': '' ?>.svg" alt="">
					</a>
				</li>
				<li>
					<a href="<?= Url::to(['/search/default/index/']) ?>">
						<img src="<?= Yii::getAlias('@web') ?>/images/paradam/search<?= $active == 'search' ? '-active': '' ?>.svg" alt="">
					</a>
				</li>
				<li>
					<a href="<?= Url::to(['/message']) ?>">
						<img src="<?= Yii::getAlias('@web') ?>/images/paradam/messages<?= $active == 'message' ? '-active': '' ?>.svg" alt="">
					</a>
				</li>
				<li>
					<a href="<?= Url::to(['/services/service']) ?>">
						<img src="<?= Yii::getAlias('@web') ?>/images/paradam/notification<?= $active == 'notification' ? '-active': '' ?>.svg" alt="">
					</a>
				</li>
			</ul>
		</nav>
	</section>
<?php endif; ?>