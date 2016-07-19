<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\admin\Admin */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-view">
   <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Set Role', ['set_role', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'password',
            'role:boolean',
            'fullname',
            'date_of_birth',
        ],
    ]) ?>

</div>
