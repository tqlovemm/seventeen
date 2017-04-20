<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/19
 * Time: 16:58
 */

namespace api\modules\v9\controllers;

use api\modules\v9\models\User;
use backend\modules\app\models\UserImage;
use Yii;
use yii\db\Query;
use yii\myhelper\Response;
use yii\rest\Controller;

class CheckUserInfoController extends Controller
{

    public $modelClass = '';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    => 'items',
    ];

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        $action =  parent::actions(); // TODO: Change the autogenerated stub
        unset($action['index'],$action['view'],$action['delete'],$action['update'],$action['create']);
        return $action;
    }

    public function actionView($id){

        $id = htmlspecialchars($id);
        $userInfo = (new Query())->from('{{%user}}')
            ->select('nickname,sex,avatar,address,birthdate')
            ->leftJoin('{{%user_profile}}','pre_user.id=pre_user_profile.user_id')->where(['pre_user.id'=>$id])->one();

        $useImage = UserImage::find()->where(['user_id'=>$id])->asArray()->one();

        if(empty($userInfo['nickname']) || empty($userInfo['avatar']) || empty($userInfo['birthdate']) || empty($userInfo['address']) || empty($useImage['img_url'])){
            Response::show('201','信息不完善，请先填写你的信息');
        }
        Response::show('200','信息完善');
    }
}