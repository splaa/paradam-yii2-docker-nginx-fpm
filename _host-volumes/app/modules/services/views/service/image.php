<?php


	use app\modules\services\models\ImageUpload;
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;

	/* @var $this yii\web\View */
	/* @var $model ImageUpload */
	/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


	<?= $nameFile = $form->field($model, 'image')->fileInput() ?>


    <div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>
</div>
