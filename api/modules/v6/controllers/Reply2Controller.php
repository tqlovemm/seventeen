<?php

namespace api\modules\v6\controllers;
use Yii;
use app\components\ActiveController;
use yii\db\Query;
use yii\helpers\Response;

class Reply2Controller extends ActiveController
{
    public $modelClass = 'api\modules\v6\models\Reply';

    public function behaviors(){

        return parent::behaviors();
    }

    public function actions()
    {
        $actions = parent::actions(); // TODO: Change the autogenerated stub
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
        return $actions;
    }

    protected function ReplaceWord($word){

        $word = mb_eregi_replace('[a-zA-Z0-9]/*','*',$word);
        $arr = ['微信','微信号','威信','歪信','歪','扣扣','扣','号码','联系方式'];
        foreach($arr as $item){//mb_eregi_replace
            $word = preg_replace('/'.$item.'/u','*',$word);
        }
        return $word;
    }

    public function actionCreate(){

        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        $user_info = (new Query())->select('nickname,avatar')->from('{{%user}}')->where(['id'=>$model->commenter_id])->one();
        $model->commenter_nickname = $user_info['nickname'];
        $model->commenter_avatar = $user_info['avatar'];
        $model->pid = 0;
        $model->comment = $this->ReplaceWord($model->comment);
        $created_at = strtotime('today');
        $updated_at = time();
        $id = isset($_POST['id'])?$_POST['id']:null;
        if(!$model->save()){
            Response::show('201','回复失败');
        }
        $insertid = Yii::$app->db->lastInsertID;
        //一级回复
        if($id == null){


            Yii::$app->db->createCommand('update pre_app_words_comment set path ='.$insertid.',created_at = '.$created_at.' ,updated_at = '.$updated_at.'  where id ='.$insertid)->execute();
            Response::show('200','回复成功',$model);
        }else{

            //多级回复
            $path = (new Query())->select('path')->from('{{%app_words_comment}}')->where(['id'=>$id])->one();
            $rpath = $path['path'].'-'.$insertid;
            Yii::$app->db->createCommand('update pre_app_words_comment set pid = '.$id.', path = \''.$rpath.'\',created_at = '.$created_at.' ,updated_at = '.$updated_at.'  where id ='.$insertid)->execute();
            Response::show('200','回复成功',$model);
        }


    }

    public function actionUpdate($id){

        $model = $this->findModel($id);
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        return $model;
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}