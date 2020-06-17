<?php

	use unclead\multipleinput\MultipleInput;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Html;


	/* @var $this yii\web\View */
	/* @var $model app\modules\services\models\Question */

	$this->title = Yii::t('app', 'Update Question: {name}', [
		'name' => $model->question,
	]);
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
	$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

		<?php $form = ActiveForm::begin([
			'enableAjaxValidation' => false,
			'enableClientValidation' => true,
			'validateOnChange' => true,
			'validateOnSubmit' => true,
			'validateOnBlur' => true,
		]); ?>





		<?= $form->field($model, 'questions')
			->widget(MultipleInput::className(), ['max' => 1,]); ?>



		<?= $form->field($model, 'convention')->checkbox(); ?>

        <div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

		<?php ActiveForm::end(); ?>


    </div>

</div>
