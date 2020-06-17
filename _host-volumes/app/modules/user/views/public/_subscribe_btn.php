<?php
	/* @var $this yii\web\View */
	/* @var $subscribe_id integer */

	use yii\helpers\Url;

?>

<?php if (Yii::$app->user->id != $user_id) { ?>
<div id="btn-subscribe">
	<?= $this->render('__subscribe_btn_block', [
		'subscribe_id' => $subscribe_id
	]) ?>

	<?php
	$action = Url::to(['public/subscribe']);
	$js = <<< JS
		$(document).on('click', '#btn-subscribe', function(){
			$.ajax({
			        url: '{$action}',
			        dataType: 'json',
			        type: 'POST',
			        data: 'user_id={$user_id}'
			    }
			).done(function(json) {
			    if (json.html) {
					$('#btn-subscribe').html(json.html);
				}

			    if (json.count) {
			        $('.ubm_counter').text(json.count);
			    }
			})
		});
JS;

	$this->registerJs($js);

?>
</div>
<?php } ?>
