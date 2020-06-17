<?php
	/**
	 * @var $service \app\modules\services\models\Service
	 * @var $user_id integer
	 */
?>

<div class="popup-like">
	<?php if (!empty($service)): ?>
		<div class="popup-like__title"><?= $service->name; ?></div>
		<ul class="servise-list">
			<li class="servise-list__item">
				<span class="servise-list__title">цена</span>
				<div class="servise-list__text"><?= $service->formatPrice ?></div>
			</li>
			<li class="servise-list__item">
				<span class="servise-list__title">Исполнение</span>
				<div class="servise-list__text"><?= $service->periodOfExecution ?> дня</div>
			</li>
		</ul>
		<div class="popup-like__text">
			<?= $service->description; ?>
		</div>
		<div class="popup-like-btn">
			<a href="#" class="like-btn">
				<span class="like-btn__count">0</span>
			</a>
			<a href="#" class="btn popup-like-btn__apply make-order" data-id="<?= $service->id; ?>" data-user-id="<?= $user_id ?>">
				Продолжить
			</a>
		</div>
	<?php else: ?>
		<div class="alert alert-danger">Нет такой услуги</div>
	<?php endif; ?>
</div>
