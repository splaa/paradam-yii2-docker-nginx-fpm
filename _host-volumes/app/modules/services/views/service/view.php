<?php

	use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

	/* @var $this yii\web\View */
	/* @var $model app\modules\services\models\Service */

	$this->title = $model->name;
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
	\yii\web\YiiAsset::register($this);
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

<section>

	<div class="mainContainer">
		<div class="steps_container">
			<div class="steps step_active_three">
				<ul>
					<li><img src="<?= Yii::getAlias('@web') ?>/images/paradam/tick.svg" alt=""></li>
					<li><img src="<?= Yii::getAlias('@web') ?>/images/paradam/tick.svg" alt=""></li>
					<li>3</li>
				</ul>
				<div class="stepsProgress stepsProgress_3"></div>
			</div>
		</div>

		<div class="consultation">
			<div class="consultation-info">
				<div class="consultation-info__title"><?= $model->name ?></div>
				<div class="consultation-info__text"><?= $model->description ?></div>
			</div>
			<div class="consultation-panel">
				<ul class="consultation-panel-list">
					<li class="consultation-panel-list__item">
						<span class="consultation-panel-list__title">цена</span>
						<span class="consultation-panel-list__info"><?= $model->price ?></span>
					</li>
					<li class="consultation-panel-list__item">
                        <span class="consultation-panel-list__title">
                            <img src="<?= Yii::getAlias('@web') ?>/images/paradam/heart.svg">
                        </span>
						<span class="consultation-panel-list__info">228</span>
					</li>
					<li class="consultation-panel-list__item">
						<span class="consultation-panel-list__title">исполнение</span>
						<span class="consultation-panel-list__info"><?= $model->periodOfExecution ?> дня</span>
					</li>
				</ul>
			</div>
		</div>



		<?php foreach ($model->questions as $key => $questions): ?>
			<div class="inputBlock inputBlock-text">
				<div class="inputBlock-top">
					<label for="name_servise" class="inputBlock-top__label">
						<span class="inputBlock-top__title">Вопрос#<?= $key + 1 ?></span>
					</label>
				</div>
				<input type="text" name="name_servise" id="name_servise" value="<?= $questions->question ?>" readonly="true">
			</div>
		<?php endforeach; ?>

		<label class="agreePpTu flex">
			<input type="checkbox" name="" id="">
			<span class="checkmark"></span>
			<p>Согласен с <a href="#"> Условиями</a></p>
		</label>
	</div>
</section>


<section>
	<div class="stepsButtons">
		<div class="stepsButtonsContainer create">
			<a href="<?= Url::to(['/user/public/', 'username' => $model->user->username]) ?>" class="create-btn">Опубликовать</a>
		</div>
	</div>
</section>