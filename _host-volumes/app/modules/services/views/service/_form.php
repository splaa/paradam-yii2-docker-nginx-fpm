<?php

use yii\widgets\ActiveForm;

	/* @var $this yii\web\View */
	/* @var $model app\modules\services\models\Service */
	/* @var $form yii\widgets\ActiveForm */
?>
<div class="mainContainer">
	<div class="steps_container">
		<div class="steps step_active">
			<ul>
				<li>1</li>
				<li>2</li>
				<li>3</li>
			</ul>
			<div class="stepsProgress stepsProgress_1"></div>
		</div>
	</div>

	<?php $form = ActiveForm::begin(['options' => ['class' => 'stepTwoBlock', 'enctype' => 'multipart/form-data']]); ?>
		<div class="inputBlock inputBlock-text">
			<div class="inputBlock-top">
				<label for="name_servise" class="inputBlock-top__label">
					<span class="inputBlock-top__title">Название</span>
					<img src="<?= Yii::getAlias('@web') ?>/images/paradam/info-icon.svg"/>
				</label>
				<div class="inputBlock-top__count">
					<span class="inputBlock-top__current">0</span>/<span class="inputBlock-top__all">50</span>
				</div>
			</div>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Название', 'class' => '', 'id' => 'name_servise', 'data-max' => 50])->label(false); ?>
		</div>

		<div class="inputBlock inputBlock-number">
			<div class="inputBlock-top">
				<label for="name_servise" class="inputBlock-top__label">
					<span class="inputBlock-top__title">Цена</span>
				</label>
			</div>
			<div class="price" id="totalPrice">500</div>
			<?= $form->field($model, 'price')->input('range', ['id' => 'costRange', 'min' => 1, 'max' => 2000, 'class' => ''])->label(false) ?>
			<div class="rezult-price">
				<div class="rezult-price__title">Вы получаете:</div>
				<div class="rezult-price-total">
					<output id="totalPriceOutput"></output><img src="<?= Yii::getAlias('@web') ?>/images/paradam/info-icon.svg"/>
				</div>
			</div>
		</div>


		<div class="inputBlock inputBlock-text">
			<div class="inputBlock-top">
				<label for="name_servise" class="inputBlock-top__label">
					<span class="inputBlock-top__title">Описание</span>
					<img src="<?= Yii::getAlias('@web') ?>/images/paradam/info-icon.svg"/>
				</label>
				<div class="inputBlock-top__count">
					<span class="inputBlock-top__current">0</span>/<span class="inputBlock-top__all">300</span>
				</div>
			</div>

			<?= $form->field($model, 'description')->textInput(['placeholder' => 'Description', 'class' => '', 'data-max' => 300, 'id' => 'desc_servise'])->label(false) ?>
		</div>

		<div class="inputBlock inputBlock-number">
			<div class="inputBlock-top">
				<label for="name_servise" class="inputBlock-top__label">
					<span class="inputBlock-top__title">Срок исполнения</span>
					<img src="<?= Yii::getAlias('@web') ?>/images/paradam/info-icon.svg"/>
				</label>
			</div>
			<output id="totalDay"></output>
			<?= $form->field($model, 'periodOfExecution')->input('range', ['id' => 'dayRange', 'min' => 1, 'max' => 14, 'class' => '', 'value' => 1])->label(false) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>