<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\setting\models\AppVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'App Versions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-version-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create App Version', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'build',
            'version',
            'app_name',
            'platform',
            // 'update_info',
            // 'url:url',
            // 'is_force_update',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
