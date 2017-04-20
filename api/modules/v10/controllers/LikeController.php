<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 11:24
 */

namespace api\modules\v10\controllers;

use api\modules\v3\models\AppPush;
use api\modules\v4\models\User;
use api\modules\v6\models\Word;
use api\modules\v7\models\Like;
use api\modules\v7\models\Message;
use Yii;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class LikeController extends Controller
{

    public $modelClass = 'api\modules\v7\models\Like';
    public $serializer = [
        'class'     =>  'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        $actions = parent::actions(); // TODO: Change the autogenerated stub
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
    }

    protected function getUsername($id){

        $userInfo = User::find()->where(['id'=>$id])->one();
        if(empty($userInfo['nickname'])){
            $userInfo['nickname'] = $userInfo['username'];
        }
        return $userInfo['nickname'];
    }

    public function actionCreate(){

        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        $decode = new Decode();
        if(!$decode->decodeDigit($model->user_id)){
            Response::show(210,'参数不正确');
        }
        $re = Word::find()->where(['id'=>$model->words_id])->one();
        if(!$re['id']){
            Response::show('201','操作失败','该帖子不存在');
        }
        //是否取消点赞
        $liked = Like::find()->where(['words_id'=>$model->words_id,'user_id'=>$model->user_id])->one();
        if(!$liked){
            if(!$model->save()){

                Response::show('201','操作失败','点赞失败');
            }else{

                $username = $this->getUsername($model->user_id);

                //添加消息提醒
                $message = new Message();
                $message->from_id =$model->user_id;
                $message->words_id =$model->words_id;
                $message->action = 1;
                $info = Word::find()->where(['id'=>$message->words_id])->one();
                $message->to_id = $info['user_id'];
                $message->save();


                //消息推送(自己给自己点赞不推送)
                $user_id = Word::find()->where(['id'=>$model->words_id])->one();
                if($user_id['user_id'] != $model->user_id){
                    $cid = User::find()->where(['id'=>$user_id['user_id']])->one();
                    if($cid['cid']){
                        $push = new AppPush();
                        $push->title = $username.' 点了个赞';
                        $push->cid = $cid['cid'];
                        $push->type = 'SSCOMM_NEWSCOMMENT_DETAIL';
                        $push->platform = 'all';
                        $push->status = 2;
                        $push->msg = $username.' 点了个赞';
                        $push->message_id = $message->attributes['id'];
                        $push->response = 'NULL';
                        $push->icon = 'http://13loveme.com:82/images/app_push/u=1630850300,1879297584&fm=21&gp=0.png';
                        $push->extras = json_encode(array('push_title'=>urlencode($push->title),'push_content'=>urlencode($push->msg),'push_post_id'=>$model->words_id,'push_type'=>'SSCOMM_NEWSCOMMENT_DETAIL'));
                        $push->save();
                        //Yii::$app->db->createCommand("insert into {{%app_push}} (type,status,cid,message_id,title,msg,extras,platform,response,icon,created_at,updated_at) values('SSCOMM_NEWSCOMMENT_DETAIL',2,'$cid[cid]','$message_id','$title','$msg','$extras','all','NULL','$icon',$date,$date)")->execute();
                    }
                }
                Response::show('200','操作成功','点赞成功');
            }
        }else{
            $res = Yii::$app->db->createCommand("delete from pre_app_words_like where words_id={$model->words_id} and user_id = {$model->user_id}")->execute();
            if($res){

                $from_id = $model->user_id;
                $words_id = $model->words_id;

                $message_id = Message::find()->where(['words_id'=>$words_id,'action'=>1])->all();
                if($message_id){
                    $data = array();
                    foreach($message_id as $list){
                        $data[] = $list['id'];
                    }
                    $data = implode(',',$data);
                    //取消点赞时，删除该条消息推送
                    Yii::$app->db->createCommand("delete from pre_app_push where message_id in ({$data})")->execute();
                }

                //取消点赞时，取消该条点赞消息提醒
                Yii::$app->db->createCommand("delete from pre_app_message where from_id = {$from_id} and words_id = {$words_id} and action = 1 ")->execute();
                Response::show('202','操作成功','取消点赞');
            }else{
                Response::show('201','操作失败','取消点赞失败');
            }
        }
    }
}