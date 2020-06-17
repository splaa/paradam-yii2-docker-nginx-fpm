<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\OrderService */

$this->title = 'Create Order Service';
$this->params['breadcrumbs'][] = ['label' => 'Order Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
