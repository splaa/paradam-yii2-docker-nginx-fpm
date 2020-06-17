<?php
	/**
	* @var \app\modules\message\models\UserThread $selected_user_thread
	* @var \yii\web\View $this
	* @var integer $froze
	*/

	use app\components\Time;
	use app\components\widgets\icon_menu\IconMenuWidget;
	use app\components\widgets\menu\MenuWidget;
	use app\modules\services\models\OrderService;
	use app\modules\user\models\User;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\View;

	$host = Yii::$app->request->hostInfo;
	$user_id = Yii::$app->user->id;
	$avatar = Yii::$app->user->identity->avatarSmall;
	$alt = Yii::$app->user->identity->alt;
	$time = Time::showDate(date("Y-m-m H:i:s"));
?>

<div class="flexPage">
	<?php if ($selected_user_thread): ?>
		<?php
			if ($selected_user_thread->thread->messageWriter) {
				$headerAvatarSmall = $selected_user_thread->thread->messageWriter->author->avatarSmall;
				$headerUsername = $selected_user_thread->thread->messageWriter->author->username;
				$headerAlt = $selected_user_thread->thread->messageWriter->author->alt;
			} else {
				$headerAvatarSmall = $selected_user_thread->thread->creator->avatarSmall;
				$headerUsername = $selected_user_thread->thread->creator->username;
				$headerAlt = $selected_user_thread->thread->creator->alt;
			}
		?>
		<!-- HEADER -->
		<header class="flexPage__contain">
			<div class="headerContainer">
				<a class="backButton" href="<?= Url::to(['/message/message/index']) ?>">
					<img src="<?= Yii::getAlias('@web') ?>/images/paradam/back_arrow.svg" alt="">
				</a>
				<div class="headerDialogs">
					<div class="headerDialogs__user">
						<div class="userAvatar userAvatar_size_medium">
							<img src="<?= $headerAvatarSmall ?>" alt="<?= $headerAlt ?>">
						</div>
						<div class="userInfo headerDialogs__userInfo">
							<span class="userInfo__name"><?= $selected_user_thread->thread->creator->alt ?></span>
							<span class="userInfo__login"><?= $headerUsername ?></span>
						</div>
					</div>
				</div>
			</div>
		</header>

		<section class="flexPage__full">
			<div class="dialogContainer">
				<div class="dialogContainer__messages msg_history">
					<?php /*if ($selected_user_thread->thread->getCreatorMessageExists()): ?>
						<div class="btn-donatat">
							<div class="btn-donatat-wrapper">
								<img src="<?= Yii::getAlias('@web') ?>/images/paradam/donation.svg" />
							</div>
						</div>
					<?php endif;*/ ?>
					<?php foreach ($selected_user_thread->thread->messages as $message): ?>
						<?php if ($message->author_id != Yii::$app->user->id): ?>
							<div class="dialogMessage">
								<div class="dialogMessage__body">
									<div class="dialogMessage__user">
										<div class="userAvatar userAvatar_size_small">
											<img src="<?= $message->author->getAvatarSmall() ?>" alt="<?= $message->author->alt ?>">
										</div>
									</div>
									<div class="dialogMessage__content">
										<div class="dialogMessage__note">
											<?php if ($message->cancel): ?>
												<span class="service__finish reason_cancel"><b>Причина отказа:</b></span>
											<?php endif; ?>

											<?php if ($message->text && $message->audio): ?>
												<?= $message->text ?>
												<audio controls="" src="<?= Yii::$app->request->hostInfo ?>/uploads/messages/<?= $message->audio ?>"></audio>
											<?php elseif ($message->audio): ?>
												<audio controls="" src="<?= Yii::$app->request->hostInfo ?>/uploads/messages/<?= $message->audio ?>"></audio>
											<?php else: ?>
												<?= $message->text ?>
											<?php endif; ?>

											<?php if (!empty($message->orderService)): ?>
												<div class="dialogMessage__note">
													<?php if ($message->orderService->status == 0): ?>
														<span class="service__button">
															<button type="button" class="btn btn-success" onclick="confirmTask(this, <?= $message->order_service_id ?>, 1, '<?= Url::to(['confirm-task']) ?>');">Задание выполнено</button>
															<button type="button" class="btn btn-danger" onclick="confirmTask(this, <?= $message->order_service_id ?>, 2, '<?= Url::to(['confirm-task']) ?>');">Отказаться от задания</button>
														</span>
														<span class="service__time"></span>
													<?php else: ?>
														<span class="service__finish">
															<b><?= OrderService::getStatusByType($message->orderService->status) ?></b>
														</span>
													<?php endif; ?>
												</div>
											<?php elseif($message->order_service_id): ?>
												<div class="dialogMessage__note">
													<span class="service__finish">
														<b><?= OrderService::getStatusByType() ?></b>
													</span>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="dialogMessage__time">
									<?= Time::showDate(date('Y-m-d H:i:s', strtotime($message->created_at))) ?>
								</div>
							</div>
						<?php else: ?>
							<!-- message start -->
								<div class="dialogMessage dialogMessage_me">
									<div class="dialogMessage__body">
										<div class="dialogMessage__content">
											<!-- сюди можна доповнювати контетн картинки видео якщо треба буде-->
											<div class="dialogMessage__note">
												<?php if ($message->cancel): ?>
													<span class="service__finish reason_cancel"><b>Причина отказа:</b></span>
												<?php endif; ?>

												<?php if ($message->text && $message->audio): ?>
													<?= $message->text ?>
													<audio controls="" src="<?= Yii::$app->request->hostInfo ?>/uploads/messages/<?= $message->audio ?>"></audio>
												<?php elseif ($message->audio): ?>
													<audio controls="" src="<?= Yii::$app->request->hostInfo ?>/uploads/messages/<?= $message->audio ?>"></audio>
												<?php else: ?>
													<?= $message->text ?>
												<?php endif; ?>
											</div>

											<?php if (!empty($message->orderService)): ?>
												<div class="dialogMessage__note">
													<?php if ($message->orderService->status == 1): ?>
														<span class="service__button">
																<b><?= OrderService::getStatusByType($message->orderService->status) ?></b>

																<button type="button" class="btn btn-success" onclick="confirmTask(this, <?= $message->order_service_id ?>, 3, '<?= Url::to(['confirm-task']) ?>');">Подтвердить выполнение</button>
																<button type="button" class="btn btn-danger" onclick="confirmTask(this, <?= $message->order_service_id ?>, 4, '<?= Url::to(['confirm-task']) ?>');">Открыть Диспут</button>
															</span>
													<?php else: ?>
														<span class="service__finish">
																<b><?= OrderService::getStatusByType($message->orderService->status) ?></b>
															</span>
													<?php endif; ?>
												</div>
											<?php elseif($message->order_service_id): ?>
												<div class="dialogMessage__note">
													<span class="service__finish">
														<b><?= OrderService::getStatusByType() ?></b>
													</span>
												</div>
											<?php endif; ?>

										</div>
									</div>
									<div class="dialogMessage__time">
										<?= Time::showDate(date('Y-m-d H:i:s', strtotime($message->created_at))) ?>
									</div>
								</div>
							<!-- message end -->
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<div class="dialogContainer__cotrol">
					<?php if ($selected_user_thread->thread->creator_id == $user_id && $froze): ?>
						<div id="control-information">
							<div class="priceCard dialogContainer__priceCard">
								<?php if ($selected_user_thread->thread->message->order_service_id): ?>
									<div class="priceCard__item">
										<span class="priceCard__label">Вы получаете:</span>
										<div class="balanceInfo">
											<span class="balanceInfo__price"><?= $selected_user_thread->thread->message->orderService->service->formatPrice ?></span>
										</div>
									</div>
									<div class="priceCard__item">
										<span class="priceCard__label">Время на выполнение:</span>
										<span class="priceCard__time">
											<?= Time::downcounter(date('Y-m-d H:i:s', strtotime($selected_user_thread->thread->message->orderService->created_at) + (int)$selected_user_thread->thread->message->orderService->service->periodOfExecution * 24 * 3600)) ?>
										</span>
									</div>
								<?php else: ?>
									<div class="priceCard__item">
										<span class="priceCard__label">Вы получаете:</span>
										<div class="balanceInfo">
											<span class="balanceInfo__price"><?= Yii::$app->user->identity->formatSmsCostPercent ?></span>
										</div>
									</div>
									<div class="priceCard__item">
										<span class="priceCard__label">Время на выполнение:</span>
										<span class="priceCard__time">
											<?= Time::downcounter(date('Y-m-d H:i:s', strtotime($selected_user_thread->thread->message->created_at) + (int)User::MESSAGE_LIVE_TIME * 24 * 3600)) ?>
										</span>
									</div>
								<?php endif; ?>
							</div>
							<div class="dialogContainer__buttonGroup">
								<?= Html::button('<img src="' . Yii::getAlias('@web') .'/images/paradam/next.svg" />',
									[
										'class' => 'ellipseButton ellipseButton_c_danger ellipseButton_s_large confirm_message',
										'data-confirm_message' => 1
									])
								?>
								<?php
									/*
										<button class="ellipseButton ellipseButton_c_default ellipseButton_s_small">
											<img src="/img/disturb.svg" />
										</button>
									*/
								?>
								<?= Html::button('<img src="' . Yii::getAlias('@web') .'/images/paradam/tick.svg" />',
									[
										'class' => 'ellipseButton ellipseButton_с_success ellipseButton_w_large confirm_message',
										'data-confirm_message' => 0
									])
								?>
							</div>
						</div>
					<?php endif; ?>

					<div class="type_msg <?= ($selected_user_thread->thread->creator_id == $user_id && $froze) ? 'hide' : '' ?>">
						<div class="buttonWithInfo">
							<button class="buttonSendMessage msg_send_btn">
								<span class="buttonSendMessage__label">Отправить сообщение <?= $selected_user_thread->thread->creator_id != $user_id ? $selected_user_thread->thread->creator->formatSmsCost : '' ?></span>
								<span class="buttonSendMessage__arrow"></span>
							</button>
							<div class="bitsCounter buttonWithInfo__bistCounter">
								<div class="bitsCounter__countContainer">
									<span class="bitsCounter__count" id="typeChars">0</span>
									/
									<span class="bitsCounter__total" id="leftChars">300</span>
								</div>
								<div class="bitsCounter__info">
									<img src="<?= Yii::getAlias('@web') ?>/images/paradam/info-icon.svg" alt="" />
									<span class="tooltip" title="This is info tooltip message!">info</span>
								</div>
							</div>
						</div>
						<div class="messageField">
							<div class="messageField__wrapper">
								<input type="text" placeholder="Введите сообщение" class="messageField__input write_msg" maxlength="300" />
								<input type="hidden" class="audio_msg"/>
							</div>
							<button type="button" class="messageField__button msg_send_btn" id="recordButton"></button>
						</div>
						<div class="record-control" id="record-control">
							<div class="timing" id="timing">00,00</div>
							<div class="cancel" id="cancel">
								<button type="button" class="messageField__button msg_send_btn" id="cancelButton">Отменить</button>
							</div>
							<div class="stop">
								<button type="button" class="messageField__button msg_send_btn" id="stopButton"></button>
							</div>
						</div>
						<div class="record-panel" id="record-panel">
							<div class="delete" id="delete">
								<button type="button" class="messageField__button msg_send_btn" id="deleteButton"></button>
							</div>
							<div id="recordingsList"></div>
						</div>
					</div>
				</div>
			</div>
		</section

		<?php
			$ws_host = Yii::$app->params['ws_host'];
			$upload_audio = Url::to(['message/upload-audio']);
			$thread_id = $selected_user_thread->thread_id;
			$creator_id = $selected_user_thread->thread->creator_id;
			$js = <<< JS
			let WS_HOST = '$ws_host';
			let upload_file = '$upload_audio';
			let sendingData = {
		        message: '',
		        audio: '',
		        timing: '',
				cancel: 0,
		        user_id: '$user_id',
		        thread_id: '$thread_id',
		        avatar: '$avatar',
		        alt: '$alt',
		        time: '$time',
		        date: '$time'
		    };
			let systemData = {
		        host: '$host',
		        user_id: '$user_id',
		        avatar: '$avatar ?>',
		        alt: '$alt',
		        time: '$time',
		        thread_id: '$thread_id',
				creator_id: '$creator_id'
		    };
		JS;

			$this->registerJs($js, View::POS_HEAD);
		?>
	<?php else: ?>
		<!-- HEADER -->
		<header class="flex-center">
			<?= IconMenuWidget::widget() ?>
			<h2>Ошибка</h2>


			<?= MenuWidget::widget() ?>
		</header>
		<!-- HEADER FIN -->

		<section>
			<div class="mainContainer">
				<div class="discoverButtons">
					<div class="alert alert-danger">Диалог не найден либо не активен</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
</div>