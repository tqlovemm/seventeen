<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenWeiUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seventeen Wei Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seventeen-wei-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'openid' => $model->openid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'openid' => $model->openid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'openid',
            'nickname',
            'address',
            'status',
            'headimgurl:image',
        ],
    ]) ?>

</div>
