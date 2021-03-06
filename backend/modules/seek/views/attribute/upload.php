<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\webuploader\MultiImage;

/* @var $this yii\web\View */
/* @var $model backend\modules\seek\models\Seek */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');

?>

<?= MultiImage::widget(); ?>

