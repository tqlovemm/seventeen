<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\DatingContent */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dating Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Dating-content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'album_id',
            'name',
            'thumb',
            'path:image',
            'store_name',
            'created_at',
            'created_by',
            'is_cover',
        ],
    ]) ?>

</div>
