<?php

	use app\modules\services\models\Question;
use app\modules\services\models\Service;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use yii\bootstrap\ActiveForm;
	use yii\helpers\Html;


	/* @var $this yii\web\View */
	/* @var $service Service */
	/* @var $model Question */

?>
<div class="mainContainer">
	<div class="steps_container">
		<div class="steps step_active_two">
			<ul>
				<li><img src="<?= Yii::getAlias('@web') ?>/images/paradam/tick.svg" alt=""></li>
				<li>2</li>
				<li>3</li>
			</ul>
			<div class="stepsProgress stepsProgress_2"></div>
		</div>
	</div>

	<div class="info">
		<div class="info-text">
			Здесь вы можете получить нужную вам информацию от заказчика, задав ему один или несколько вопросов.
		</div>
		<div class="info-link">
			<a href="" class="">Нажмите</a>, чтобы посмотреть пример.
		</div>
	</div>

	<?php $form = ActiveForm::begin([
		'enableAjaxValidation' => false,
		'enableClientValidation' => true,
		'validateOnChange' => true,
		'validateOnSubmit' => true,
		'validateOnBlur' => true
	]); ?>
		<div class="questions_container">
			<div class="inputBlock inputBlock-text">
				<?= $form->field($service, 'questions')->widget(MultipleInput::className(), [
					'max' => 10,
					'theme' => MultipleInput::THEME_DEFAULT,
					'rendererClass' => \unclead\multipleinput\renderers\DivRenderer::className(),
					'addButtonPosition' => MultipleInput::POS_FOOTER,
					'addButtonOptions' => [
						'class' => 'ib_add_button'
					],
					'removeButtonOptions' => [
						'class' => 'ib_remover flex-icon',
						'label' => Html::tag('img', null, ['src' => Yii::getAlias('@web') . '/images/paradam/input_eraser.svg'])
					],
					'columns' => [
						[
							'name' => 'questions',
							'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
							'value' => function($data) {
								return $data->question ?? '';
							},
							'options' => [
								'placeholder' => 'Name',
							],
						],
					],
				])->label(false); ?>
			</div>
			<div class="inputBlock inputBlock-add" id="button_add_question">
				Добавить вопрос +
			</div>
		</div>
	<?php ActiveForm::end(); ?>
</div>