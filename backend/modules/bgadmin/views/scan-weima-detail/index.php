<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bgadmin\models\ScanWeimaDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scan Weima Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scan-weima-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Scan Weima Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sence_id',
            'customer_service',
            'account_manager',
            'description',
            //'local_path',
            //'remote_path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
