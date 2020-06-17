<?php
/* @var $model \app\modules\user\models\User */

use yii\helpers\Url;

?>
<a class="userItem" href="<?= Url::to($model->username, ['public/', 'username' => $model->username]) ?>">
	<div class="userItem__avatar userAvatar userAvatar_size_small">
		<img src="<?= $model->avatarSmall ?>" alt="<?= $model->alt ?>">
	</div>
	<div class="userItem__conent">
		<div class="userItem__header">
			<div class="userItem__name">
				<?= $model->first_name ?> <?= $model->last_name ?>
			</div>
			<div class="userItem__login">
				<?= $model->username ?>
			</div>
		</div>
		<div class="userItem__bookmark"><?= $model->subscribersCount ?> on bookmarks</div>
	</div>
</a>