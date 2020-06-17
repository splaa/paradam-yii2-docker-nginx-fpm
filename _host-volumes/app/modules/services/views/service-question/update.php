<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\services\models\ServiceQuestion */

$this->title = Yii::t('app', 'Update Service Question: {name}', [
    'name' => $model->service_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->service_id, 'url' => ['view', 'service_id' => $model->service_id, 'question_id' => $model->question_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="service-question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
