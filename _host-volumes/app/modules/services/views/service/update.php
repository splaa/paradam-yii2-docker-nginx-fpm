<?php

	use yii\helpers\Html;

	/* @var $this yii\web\View */
	/* @var $model app\modules\services\models\Service */

	$this->title = Yii::t('app', 'Update Service: {name}', [
		'name' => $model->name,
	]);
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
	$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
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
			<div class="sb_button sb_back">
				<a href="#" onclick="main.back()">
					<span><img src="<?= Yii::getAlias('@web') ?>/images/paradam/btn-back.svg" alt="">Back</span>
				</a>
			</div>
			<div class="sb_button sb_next">
				<a href="#" onclick="$('#service_block_form').find('form').submit();">Next<img src="<?= Yii::getAlias('@web') ?>/images/paradam/btn-next.svg" alt=""></a>
			</div>
		</div>
	</div>
</section>
<?php /*
<div>
	<h3>Вопросы</h3>
	<div class="box">
		<div class="box-body">
			<?php
			$form = \yii\bootstrap\ActiveForm::begin()
			?>
			<?php foreach ($model->questions as $questions): ?>

				<?= $form->field($questions, 'question'); ?>


			<?php endforeach; ?>
			<?php \yii\bootstrap\ActiveForm::end(); ?>
		</div>
	</div>
</div>
 */ ?>