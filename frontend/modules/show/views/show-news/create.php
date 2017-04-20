<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\show\models\ShowNews */

$this->title = 'Create Show News';
$this->params['breadcrumbs'][] = ['label' => 'Show News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="show-news-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
