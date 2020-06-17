<?php
	use himiklab\yii2\recaptcha\ReCaptcha2;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

	/* @var $step_1 string */
	/* @var $step_2 string */
	/* @var $step_3 string */
	/* @var $step_4 string */

	$this->title = 'Регистрация';
	$this->params['breadcrumbs'][] = $this->title;
?>
	<header class="loginHeader">
		<h2>Paradam,</h2>
	</header>

	<!-- HEADER FIN -->
	<section class="registration">
		<!-- Nav tabs -->
		<ul class="hide" id="stepsRegister" role="tablist">
			<li role="presentation" class="active"><a href="#step_1" aria-controls="step_1" role="tab" data-toggle="tab"></a></li>
			<li role="presentation"><a href="#step_2" aria-controls="step_2" role="tab" data-toggle="tab"></a></li>
			<li role="presentation"><a href="#step_3" aria-controls="step_3" role="tab" data-toggle="tab"></a></li>
			<li role="presentation"><a href="#step_4" aria-controls="step_4" role="tab" data-toggle="tab"></a></li>
		</ul>
		<div class="tab-content">

			<div role="tabpanel" class="tab-pane active" id="step_1" data-tab-next="step_2">
				<?= $step_1 ?>
			</div>

			<div role="tabpanel" class="tab-pane" id="step_2" data-tab-next="step_3">
				<?= $step_2 ?>
			</div>

			<div role="tabpanel" class="tab-pane" id="step_3" data-tab-next="step_4">
				<?= $step_3 ?>
			</div>

			<div role="tabpanel" class="tab-pane" id="step_4">
				<?= $step_4 ?>
			</div>

		</div>
	</section>


<?php
$url = Url::to(['phoneidentity/telephone-code-confirm']);
$js = <<< JS
	$(document).ready(function() {
		$('form').on('beforeSubmit', function(){
			let form = $(this);
			let data = form.serialize();

			$.ajax({
				url: form.attr('action'),
				type: 'POST',
				data: data,
				success: function(json){
					if (json['error']) {
						form.html('<div class="alert alert-danger">' + json['error'] + '</div>');
					} else if (json['success']) {
						let tab_next = form.parents('.tab-pane.active').data('tab-next');
						$('#stepsRegister a[href="#' + tab_next + '"]').tab('show');

						if (json['text']) {
							$('#' + tab_next).find('.text').html(json['text']);
						}
					} else if (json['validation']) {
						form.yiiActiveForm('updateMessages', json['validation'], true);
					}
				},
				error: function(){
					console.log('Error!');
				}
			});
			return false;
		});
	});
JS;

$this->registerJs($js);

?>