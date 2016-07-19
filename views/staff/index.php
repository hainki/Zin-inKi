<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a('Create Staff', ['create_staff'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'password',
            'role:boolean',
            'fullname',
            // 'date_of_birth',
            // 'created_date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{set_role}',
                'buttons' => [
                    'set_role' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-user"></span>', $url);
                    },
                ],
            ],
        ],
    ]);
    ?>
<?php Pjax::end(); ?></div>
