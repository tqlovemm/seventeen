<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\setting\models\AppVersion */

$this->title = 'Create App Version';
$this->params['breadcrumbs'][] = ['label' => 'App Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-version-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
