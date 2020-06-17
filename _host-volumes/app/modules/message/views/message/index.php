<?php
/**
 * @var \app\modules\message\models\UserThread[] $threads
 * @var \app\modules\message\models\UserThread $selected_user_thread
 * @var \app\modules\message\forms\SettingsForm $model
 * @var integer $froze
 */

use app\components\Hash;
use app\components\widgets\icon_menu\IconMenuWidget;
use app\components\widgets\menu\MenuWidget;
use kartik\typeahead\Typeahead;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Pjax;

?>
<!-- HEADER -->
<header class="flex-center">
	<?= IconMenuWidget::widget() ?>
	<h2>Сообщения</h2>


	<?= MenuWidget::widget() ?>
</header>
<!-- HEADER FIN -->

<section>
	<div class="mainContainer">
		<div class="messages_container">
			<?php if ($threads): ?>
				<?php foreach ($threads as $thread): ?>
					<?php
						$hash = new Hash();
						$hash->string = $thread->thread->id;

						if ($thread->thread->messageWriter) {
							$avatarSmall = $thread->thread->messageWriter->author->avatarSmall;
							$username = $thread->thread->messageWriter->author->username;
							$alt = $thread->thread->messageWriter->author->alt;
						} else {
							$avatarSmall = $thread->thread->creator->avatarSmall;
							$username = $thread->thread->creator->username;
							$alt = $thread->thread->creator->alt;
						}
					?>
					<div class="messages_item flex" onclick="window.location.href='<?= Url::to(['view', 'id' => $hash->run(Hash::ENCODE)]) ?>'">
						<div class="mi_avatar">
							<img src="<?= $avatarSmall ?>" alt="<?= $alt ?>">
						</div>
						<div class="mi_information flex-between">
							<div class="mi_left mi_msg">
								<span><?= $username ?></span>

								<?php if (!empty($thread->thread->message->author)): ?>
									<p>
										<?php if ($thread->thread->message->author->id == Yii::$app->user->id): ?>
											<?php if ($thread->thread->message->audio): ?>
												Voice message
											<?php else: ?>
												<?= mb_substr($thread->thread->message->text, 0, 100) ?>...
											<?php endif; ?>
										<?php else: ?>
											<span class="text">Новое сообщение</span>
										<?php endif; ?>
									</p>
								<?php endif; ?>
							</div>
							<div class="mi_right">
								<span>+10$</span>
								<p>3d left</p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="alert alert-warning">У Вас нет активных диалогов</div>
			<?php endif; ?>
		</div>
	</div>
</section>