<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\services\models\ServiceQuestion */

$this->title = Yii::t('app', 'Create Service Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
