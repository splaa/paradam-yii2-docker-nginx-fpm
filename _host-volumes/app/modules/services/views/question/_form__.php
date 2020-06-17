<?php

	use app\assets\AppAsset;
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;

	/* @var $this yii\web\View */
	/* @var $model app\modules\services\models\Question */
	/* @var $form yii\widgets\ActiveForm */

	$this->registerJsFile(
		'@web/question/js/questions.js',
		['depends' => [AppAsset::className()]]
	);
	//		$this->registerJsFile('@web/question/js/jquery.js');

	$this->registerCssFile('@web/question/css/questions.css');
?>

<div class="question-form" id="container">
    <div class="dynamic-form">
        <a href="#" id="add">Добавить</a> | <a href="#" id="remove">Удалить</a> | <a href="#" id="reset">Сбросить</a>

		<?php $form = ActiveForm::begin(); ?>


        <div class="inputs">
            <div><input type="text" name="dynamic[]" class="field" value="1"></div>
        </div>
        <input name="submit" type="button" class="submit" value="ОК">


        <!--    --><?php //= $form->field($model, 'created_at')->textInput() ?>

        <!--    --><?php //= $form->field($model, 'updated_at')->textInput() ?>


		<?= $form->field($model, 'question')->textInput(['maxlength' => true]) ?>

        <!--    --><?php //= $form->field($model, 'status')->textInput() ?>

        <div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

		<?php ActiveForm::end(); ?>


    </div>


</div>

