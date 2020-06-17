<?php

/* @var $this \yii\web\View */

/* @var $content string */
/* @var $this View */
/* @var $content string */

use app\assets\AppAsset;
use app\modules\user\models\User;
use app\widgets\Alert;
use kartik\typeahead\Typeahead;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\ParadamAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Breadcrumbs;
use yii\web\View;

AppAsset::register($this);
\app\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->registerCsrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<?php
	NavBar::begin([
		'brandLabel' => Yii::$app->name,
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar-inverse navbar-fixed-top',
		],
	]);
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right'],
		'activateParents' => true,
		'items' => array_filter([
			['label' => Yii::t('app', 'NAV_HOME'), 'url' => ['/main/default/index']],
			['label' => Yii::t('app', 'NAV_USERS'), 'url' => ['/user/public/list']],
			Yii::$app->user->isGuest ?
				['label' => Yii::t('app', 'NAV_SIGNUP'), 'url' => ['/user/phoneidentity/index']] :
				false,
			Yii::$app->user->isGuest ?
				['label' => Yii::t('app', 'NAV_LOGIN'), 'url' => ['/user/default/phonelogin']] :
				false,
			!Yii::$app->user->isGuest ?
				['label' => Yii::t('app', 'NAV_ADMIN'), 'items' => [
					['label' => Yii::t('app', 'NAV_ADMIN'), 'url' => ['/admin/default/index']],
					['label' => Yii::t('app', 'NAV_SERVICES'), 'url' => ['/services/service']],
					['label' => Yii::t('app', 'NAV_QUESTIONS'), 'url' => ['/services/question']],
					['label' => Yii::t('app', 'ADMIN_USERS'), 'url' => ['/admin/users/index']],
					['label' => Yii::t('app', 'ADMIN_THREAD'), 'url' => ['/admin/thread/index']],
					['label' => Yii::t('app', 'ADMIN_ORDERS'), 'url' => ['/admin/order-service/index']],
				]] :
				false,
			!Yii::$app->user->isGuest ?
				['label' => Yii::t('app', 'NAV_PROFILE'), 'items' => [
					['label' => Yii::t('app', 'NAV_PROFILE'), 'url' => ['/user/profile/index']],
					['label' => sprintf(Yii::t('app', 'NAV_PROFILE_BALANCE'), Yii::$app->user->identity->formatBalance, Yii::$app->user->identity->convertBalanceToUSD), 'url' => ['/user/profile/balance']],
					['label' => Yii::t('app', 'NAV_LOGOUT'),
						'url' => ['/user/default/logout'],
						'linkOptions' => ['data-method' => 'post']]
				]] :
				false,
			Yii::$app->user->can('admin') ?
				['label' => Yii::t('app', 'NAV_ADMIN'), 'items' => [
					['label' => Yii::t('app', 'NAV_ADMIN'), 'url' => ['/admin/default/index']],
					['label' => Yii::t('app', 'ADMIN_USERS'), 'url' => ['/admin/users/index']],
				]] :
				false,
			Yii::$app->language === 'en' ?
				['label' => Yii::t('app', 'Русский'), 'url' => ['/', 'language' => 'ru']] :
				false,
			Yii::$app->language === 'ru' ?
				['label' => Yii::t('app', 'English'), 'url' => ['/', 'language' => 'en']] :
				false,


		]),
	]);
	NavBar::end();
	?>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php $template = '<a href="{{link}}" class="search-top clearfix"><img src="{{avatar}}"><span class="search-username">{{value}}</span><span class="search-fullname">{{full_name}}</span></a>';?>
				<?=
				Typeahead::widget([
					'name' => 'user',
					'id' => 'userTypeahead',
					'options' => ['placeholder' => 'Search user ...'],
					'scrollable' => true,
					'dataset' => [
						[
							'display' => 'value',
							'limit' => 50,
							'remote' => [
								'url' => Url::to(['/user/search/index']) . '?q=%QUERY',
								'wildcard' => '%QUERY',
								'rateLimitWait' => 1000
							],
							'templates' => [
								'notFound' => '<div class="text-danger" style="padding:0 8px">Ничего не найдено.</div>',
								'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
							]
						]
					],
					'pluginOptions' => [
						'highlight' => true,
						'minLength' => 1,
						'val' => ''
					],
				]);
				?>
			</div><!-- /.col-lg-6 -->
		</div><!-- /.row -->
	</div>

	<div class="container">
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
		<?= Alert::widget() ?>

		<?= $content ?>
	</div>
</div>

<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>
		<p class="pull-right"><?= date('Y-m-d') ?></p>
	</div>
</footer>
<?= $content ?>

<?php
Modal::begin([
	'id' => 'order',
	'size' => 'modal-lg',
	'header' => '<h2>Услуги</h2>',
	'footer' => '<button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button><button type="button" class="btn btn-info" id="checkout_service">Оформить</button>'
]);

?>

<?php
Modal::end();
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
