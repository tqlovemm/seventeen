<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\forum\models\AnecdoteThreadThumbsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anecdote Thread Thumbs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-thread-thumbs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('查看爆料', ['/good/default/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('查看爆料用户', ['/good/anecdote-users/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('查看爆料的评论', ['/good/anecdote-thread-comments/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('查看爆料评论的回复', ['/good/anecdote-thread-comment-comments/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('查看审核被举报的爆料', ['/good/anecdote-thread-report/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('添加点赞', ['/good/anecdote-thread-report/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'thumbs_id',
            'tid',
            'user_id',
            'type',
            'where',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
