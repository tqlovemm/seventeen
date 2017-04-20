<?php

namespace api\modules\v7\controllers;

use api\modules\v5\models\User;
use yii;
use yii\rest\ActiveController;
use api\modules\v6\models\MemberSort;

class MemberSortController extends ActiveController
{

    public $modelClass = 'api\modules\v6\models\Member';
    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        $actions =  parent::actions(); // TODO: Change the autogenerated stub
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
        return $actions;
    }

    public function actionView($id){


        $model = new $this->modelClass();
        $userInfo = $model::findOne($id);
        $arr = array(2,3,4);

        if(!in_array($userInfo->groupid,$arr)){

            $str = array(
                'code'  =>  '201',
                'msg'   =>  '操作失败',
                'data'  =>  '用户是非会员',
                'is_status' =>  0, //1审核环境；0生产环境
            );

        }else{

            $str = array(
                'code'  =>  '200',
                'msg'   =>  '操作成功',
                'data'  =>  '用户是会员',
                'is_status' =>  0,//1审核环境；0生产环境
            );
        }
        return $str;
    }

    public function actionIndex(){

        $uid = $_GET['uid'];
        $level = (new User())->find()->select('groupid')->where(['id'=>$uid])->one();
        $result = (new MemberSort())->find()->where(['flag'=>1])->orderby(' id DESC ')->all();
        $lunbo = (new yii\db\Query())->from('{{%app_lunbo}}')->where('')->all();
        //审核状态 1 ，生产状态 0
        $status = 0;

        if($status == 1){
            for($i = 0 ; $i < count($result); $i ++){
                if($i == 0){
                    $result[0]['price_1'] = 4998;
                    $result[0]['giveaway'] = 1880;
                }else if($i == 1){
                    $result[1]['price_1'] = 1998;
                    $result[1]['giveaway'] = 990;
                }
            }
        }
        $str = array(
            'user_level'    =>  $level['groupid'],
            'member' => $result,
            'is_status' => $status,
            'lunbo' =>  $lunbo,
        );
        return $str;
    }

}