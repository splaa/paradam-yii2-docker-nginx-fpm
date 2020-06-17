<?php

use app\components\grid\LinkColumn;
use app\modules\admin\components\SetColumn;
use app\modules\admin\models\User;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'USERS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
        <div class="box-body">
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			'id',
			[
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'date_from',
					'attribute2' => 'date_to',
					'type' => DatePicker::TYPE_RANGE,
					'separator' => '-',
					'pluginOptions' => ['format' => 'yyyy-mm-dd']
				]),
				'attribute' => 'created_at',
				'format' => 'datetime',
			],
			[
				'class' => LinkColumn::className(),
				'attribute' => 'username',
			],
			'email:email',
			[
				'class' => SetColumn::className(),
				'filter' => User::getStatusesArray(),
				'attribute' => 'status',
				'name' => 'statusName',
				'cssCLasses' => [
					User::STATUS_ACTIVE => 'success',
					User::STATUS_WAIT => 'warning',
					User::STATUS_BLOCKED => 'default',
				],
			
			],
			['class' => 'app\components\grid\ActionColumn'],
		],
	]) ?>
        </div>
    </div>

</div>
