<?php
$this->title = "聊天记录";
?>
<?= $this->render('_view', [
    'model' => $model,
    'weimas'=>$weimas,
    'pagination'=>$pagination,
    'imgs'=>$imgs,
    'count'=>$count,
    'pagination2'=>$pagination2,
    'record'=>$record,
]) ?>