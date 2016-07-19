<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\object\CheckIn;
use app\object\CheckOut;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Time login/logout';
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View login/logout time';
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php Pjax::begin(); ?>    <?= GridView::widget([
	        'dataProvider' => $dataProvider,
	        'columns' => [
	            ['class' => 'yii\grid\SerialColumn'],
	
	            'login_time',
	            'logout_time',
	            // 'date_of_birth',
	            // 'created_date',
	
	        		[
	        		'class' => 'yii\grid\ActionColumn',
	        				'template' => ''
	        	],
	        ],
	    ]); ?>
	<?php Pjax::end(); ?>

</div>
