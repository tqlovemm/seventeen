<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Exciting',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->tid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="album-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
