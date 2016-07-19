<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\object\CheckIn;
use app\object\CheckOut;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Check logs';
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Check logs';
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Check-in', ['checklogs?a=check-in'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Check-out', ['checklogs?a=check-out'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',
            'check_in_time',
            'check_out_time',
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
