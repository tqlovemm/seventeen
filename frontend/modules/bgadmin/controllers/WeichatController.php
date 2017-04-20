<?php

namespace frontend\modules\bgadmin\controllers;
use app\components\WxpayComponents;
use backend\modules\seventeen\models\SeventeenWeiUser;
use yii\web\Controller;
use Yii;
use yii\web\ForbiddenHttpException;
class WeichatController extends Controller
{
    public $wxpay;

    public function init()
    {
        $this->wxpay = new WxpayComponents();
        parent::init(); // TODO: Change the autogenerated stub
        if($this->wxpay->judgeCookie()){
            return $this->redirect('choice-address');
        }

    }

    public function actionSeventeenCode(){

        $callback = "http://13loveme.com/bgadmin/seventeen-man/seventeen";
        $options = array('appid'=>Yii::$app->params['appid']);
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        return $this->redirect($url);
    }
    public function actionSeventeen(){

        $options = array('appid'=>Yii::$app->params['appid'], 'appsecret'=>Yii::$app->params['appsecret']);
        $data['code'] = Yii::$app->request->get('code');

        if(!empty($data['code'])) {

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";
            $result = json_decode(file_get_contents($url));
            $openid = $result->openid;
            $access_token = $result->access_token;
            $url_user_info = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            $user_info = json_decode(file_get_contents($url_user_info),true);
            $headimgurl = $user_info['headimgurl'];
            $nickname = $user_info['nickname'];

            if (!empty($openid)) {
                $query = SeventeenWeiUser::findOne(['openid'=>$openid]);
                if(empty($query)){
                    $query = new SeventeenWeiUser();
                    $query->openid = $openid;
                    $query->nickname = $nickname;
                    $query->headimgurl = $headimgurl;
                    $query->save();

                }
                $this->wxpay->addCookie('openid',$openid);
                $this->wxpay->addCookie('nickname',$nickname);
                $this->wxpay->addCookie('headimgurl',$headimgurl);

                return $this->redirect('choice-address');

            }else{

                throw new ForbiddenHttpException('非法访问');
            }
        }

    }

}