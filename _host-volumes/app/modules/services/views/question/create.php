<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $service app\modules\services\models\Service */
/* @var $model app\modules\services\models\Question */
/* @var $back string */

$this->title = Yii::t('app', 'Create Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
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

<section id="question_block_form">
	<?= $this->render('_form', [
		'service' => $service,
		'model' => $model,
	]) ?>
</section>


<section>
	<div class="stepsButtons">
		<div class="stepsButtonsContainer">
			<div class="sb_button sb_back">
				<a href="<?= $back; ?>">
					<span><img src="<?= Yii::getAlias('@web') ?>/images/paradam/btn-back.svg" alt="">Back</span>
				</a>
			</div>
			<div class="sb_button sb_next">
				<a href="#" onclick="$('#question_block_form').find('form').submit();">Next<img src="<?= Yii::getAlias('@web') ?>/images/paradam/btn-next.svg" alt=""></a>
			</div>
		</div>
	</div>
</section>
