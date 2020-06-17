<?php
	/**
	 * @var $service \app\modules\services\models\Service
	 * @var $user_id integer
	 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Услуги";
	Yii::$app->params['modalTitle'] = 'Услуги'
?>

<!-- HEADER -->
<header>
	<div class="headerContainer">
        <span class="backButton">
            <img src="<?= Yii::getAlias('@web') ?>/images/paradam/back_arrow.svg" alt="">
        </span>
		<h2><?= $service->name; ?></h2>
	</div>
</header>
<?php if (Yii::$app->user->isGuest): ?>
	<section>
		<div class="alert alert-danger">Авторизируйтесь или ввойдите</div>
	</section>
<?php else: ?>
	<!-- HEADER FIN -->
	<form action="<?= Url::to(['order/save']) ?>" id="send_service_form">
		<div class="form__error"></div>
		<section>
			<div class="mainContainer like-page">
				<?php if (!empty($service)): ?>
					<div class="info">
						<div class="info-text"><?= $service->description; ?></div>
					</div>

					<?php foreach ($service->questions as $question): ?>
						<div class="inputBlock inputBlock-text">
							<div class="inputBlock-top">
								<label for="question" class="inputBlock-top__label">
									<span class="inputBlock-top__title"><?= $question->question ?> <span class="required">*</span></span>
								</label>
							</div>
							<input type="text" placeholder="Ответ" name="answered[<?= $service->id ?>][<?= $question->id ?>]" class="req" data-error="Обязательно для заполнения">
						</div>
					<?php endforeach; ?>

					<div class="inputBlock inputBlock-text">
						<div class="inputBlock-top">
							<label for="question" class="inputBlock-top__label">
								<span class="inputBlock-top__title">Ваш комментарий</span>
							</label>
						</div>
						<textarea name="comment" id="comment" cols="30" rows="10" placeholder="Comment"></textarea>
					</div>

					<label class="agreePpTu flex">
						<input type="checkbox" name="terms_of_use" value="1" id="" class="req" data-error="Обязательно для заполнения" />
						<span class="checkmark"></span>
						<p>Согласен с <a href="#"> Условиями</a></p>
					</label>
				<?php else: ?>
					<div class="alert alert-danger">Пусто</div>
				<?php endif; ?>
			</div>
		</section>

		<?php if (!empty($service)): ?>
			<section>
				<div class="stepsButtons">
					<div class="stepsButtonsContainer create">
						<a href="#" id="checkout_service" class="create-btn">Заказать за  <strong> <?= $service->convertPriceToUSD ?></strong></a>
					</div>
				</div>
			</section>
		<?php endif; ?>
		<input type="hidden" value="<?= $user_id ?>" name="user_id" />
	</form>
<?php endif; ?>

