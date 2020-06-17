<?php

	use yii\helpers\Html;

	/* @var $this yii\web\View */
	/* @var $model app\modules\services\models\Service */

	$this->title = Yii::t('app', 'Create Service');
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>


<!-- HEADER -->
<header>
	<div class="headerContainer">
        <span onclick="main.back()" class="backButton">
            <img src="<?= Yii::getAlias('@web') ?>/images/paradam/back_arrow.svg" alt="">
        </span>
		<h2><?= Html::encode($this->title) ?></h2>
	</div>
</header>

<!-- HEADER FIN -->

<section id="service_block_form">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</section>

<section>
	<div class="stepsButtons">
		<div class="stepsButtonsContainer">
			<div class="sb_button sb_next">
				<a href="#" onclick="$('#service_block_form').find('form').submit();return false;">Next<img src="<?= Yii::getAlias('@web') ?>/images/paradam/btn-next.svg" alt=""></a>
			</div>
		</div>
	</div>
</section>