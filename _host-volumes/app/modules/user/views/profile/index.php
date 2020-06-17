<?php
	// paradam.me.loc/index.php


use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use yii\helpers\Html;
	use yii\widgets\DetailView;

	/* @var $this yii\web\View */
	/* @var $model app\modules\user\models\User */

	$this->title = Yii::t('app', 'TITLE_PROFILE');
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
	<div class="mainContainer">
		<div class="list-group">
			<?= Html::a(Yii::t('app', 'BUTTON_UPDATE'), ['update'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_PASSWORD_CHANGE'), ['password-change'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_TO_PHONE_CHANGE'), ['telephone-change'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_TO_MESSAGES'), ['/message/message/index'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_TO_AVATAR'), ['upload-avatar'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_TO_COVER'), ['upload-cover'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_TO_MESSAGE_SETTINGS'), ['/message/message/settings'], ['class' => 'list-group-item']) ?>
			<?= Html::a(sprintf(Yii::t('app', 'NAV_PROFILE_BALANCE'), Yii::$app->user->identity->formatBalance, Yii::$app->user->identity->convertBalanceToUSD), ['balance'], ['class' => 'list-group-item']) ?>
			<?= Html::a(sprintf(Yii::t('app', 'NAV_PROFILE_CHANGE_NAME'), Yii::$app->user->identity->formatBalance), ['name-change'], ['class' => 'list-group-item']) ?>
			<?= Html::a(sprintf(Yii::t('app', 'NAV_PROFILE_CHANGE_USER_NAME'), Yii::$app->user->identity->formatBalance), ['user-name-change'], ['class' => 'list-group-item']) ?>
			<?= Html::a(sprintf(Yii::t('app', 'NAV_PROFILE_CHANGE_DATE'), Yii::$app->user->identity->formatBalance), ['date-change'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_TO_DESCRIPTION_CHANGE'), ['description-change'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_TO_LINK_CHANGE'), ['link-change'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'NAV_SERVICES'), ['/services/service'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'NAV_QUESTIONS'), ['/services/question'], ['class' => 'list-group-item']) ?>
			<?= Html::a(Yii::t('app', 'LINK_TO_LINK_ADD_LANGUAGES'), ['add-languages'], ['class' => 'list-group-item']) ?>
		</div>

		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'username',
				[
					'label' => 'електронный адрес',
					'attribute' => 'email',
				],
				[
					'attribute' => 'first_name',
					'label' => 'Услуги',
					'format' => 'raw',
					'value' => function ($data) {
						return '<a href="/services/service">Услуги</a>';
					}
				],
				'telephone',
				'balance',
				[
					'attribute' => 'status',
					'format' => 'raw',
					'value' => function ($data) {
						return $data->status ? '<span class="text-success">Активный</span>' : '<span class="text-danger">Не Активный</span>';
					}
				],
			],
		]) ?>
	</div>
</section>