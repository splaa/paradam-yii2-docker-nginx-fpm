<?php
/* @var $model \app\modules\user\models\User */
/* @var $messageForm \app\modules\message\forms\MessageForm */
/* @var $services \app\modules\services\models\Service[] */
/* @var $this yii\web\View */
/* @var $subscribe_id integer */

/* @var $count integer */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::$app->request->baseUrl . '@web/js/order.js', ['depends' => [AppAsset::class]]);
?>

<header class="profileHeader">
	<div class="headerContainer headerContainer-profile">
        <span onclick="main.back()" class="backButton">
            <img src="<?= Yii::getAlias('@web') ?>/images/paradam/back_arrow_w.svg" alt="">
        </span>
		<h2><?= $model->first_name . ' ' . $model->last_name ?></h2>
		<span class="backButton">
            <?= $this->render('_subscribe_btn', [
	            'subscribe_id' => $subscribe_id,
	            'user_id' => $model->id
            ]) ?>
        </span>
	</div>

</header>

<section>
	<div class="carousel" data-flickity='{ "cellAlign": "left", "contain": true }'>
		<div class="carousell_cell">
			<div class="pup_fader"></div>
			<div class="profileUserPhoto">
				<img src="<?= $model->cover ?>" alt="">
			</div>

		</div>
		<div class="carousell_cell">
			<div class="cc_header_bg"></div>
			<div class="profileUserContainer">
				<div class="profileUserInfo">
					<div class="pui_top">
						<div class="pui_left">
							<div class="userAvatarMIn" style="background: url(<?= $model->avatarSmall ?>);background-size: 100%;">
							</div>
						</div>
						<div class="pui_right">
							<div class="userNickName_container">
								<span>username</span>
								<h3 class="userNickName"><?= $model->username ?></h3>
							</div>
							<div class="userBookMarks">
								<span>on bookmarks</span>
								<div class="ubm_counter"><?= $count ?></div>
							</div>
						</div>
					</div>

					<div class="userProfileDescription">
						<div class="upd_text">
							<?= $model->description ?>
						</div>
						<div class="upd_link">
							<a href="<?= $model->link ?>" target="_blank"><?= $model->linkFormat ?></a>
						</div>
						<?php if($model->languageArray): ?>
							<div class="upd_lang">
								<ul>
									<?php foreach($model->languageArray as $language): ?>
										<li><?= $language ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if (Yii::$app->user->id != $model->id): ?>
		<div class="upd_button">
			<?php $form = ActiveForm::begin(['action' => Url::to(['/message/message/create']), 'method' => 'POST']); ?>
				<?= $form->field($messageForm, 'user_id')->input('hidden', ['value' => $model->id])->label(false) ?>
				<?= $form->field($messageForm, 'text')->input('hidden', ['value' => ''])->label(false) ?>
				<?= Html::submitButton('Отправить  сообщение ' . $model->formatSmsCost, ['class' => '', 'id' => 'send_msg']) ?>
			<?php ActiveForm::end(); ?>
		</div>
	<?php else: ?>
		<div class="balance_btn">
			<div class="bb_container flex-center">
				<span class="bb_wallet">
					<img src="<?= Yii::getAlias('@web') ?>/images/paradam/wallet.svg" alt="">
				</span>
				<div class="balance_counter flex-center">
					<span><?= $model->convertBalanceToUSD ?> </span>
					<p>Balance</p>
				</div>
				<a href="#" class="bb_deposit flex-icon">
					<img src="<?= Yii::getAlias('@web') ?>/images/paradam/balance_add.svg" alt="">
				</a>
			</div>
		</div>
	<?php endif; ?>

	<div class="mainContainer">

		<div class="userServices">
			<p class="us_title"><?= $model->first_name . ' ' . $model->last_name ?> offers:</p>

			<div class="us_itemsContainer">
				<?php if (Yii::$app->user->id == $model->id): ?>
					<a href="<?= Url::to(['/services/service/create']) ?>" class="usic_item_button">
						<span>Add new service <b>+</b></span>
					</a>
				<?php endif; ?>

				<?php foreach ($services as $service): ?>
					<?php if (Yii::$app->user->id != $model->id): ?>
						<div class="usic_item make-order-preview" data-id="<?= $service->id ?>" data-user-id="<?= $model->id ?>">
					<?php else: ?>
						<div class="usic_item">
					<?php endif; ?>
						<div class="usici_top">
							<div class="usicit_name"><?= $service->name ?></div>
							<div class="usicit_price"><?= $service->formatPrice ?></div>
						</div>
						<div class="usici_mid">
							<div class="usicim_description">
								<?= $service->description ?>
							</div>
							<span class="usicim_favorite">
	                            <img src="<?= Yii::getAlias('@web') ?>/images/paradam/heart.svg" alt="">
	                        </span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<div class="popup-like-wrap" id="popup-like">

</div>
<section class="hover_block" id="page_service">
	<div class="desc not_swipe"></div>
</section>