<?php

namespace api\modules\v3\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "pre_weekly".
 *
 * @property integer $id
 * @property string $content
 * @property string $number
 * @property string $title
 * @property string $url
 * @property string $avatar
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $status
 * @property integer $worth
 * @property integer $expire
 */
class Dating extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%weekly}}';
    }

    public function getId()
    {
        return $this->id;
    }


    public function rules()
    {
        return [

            [['content','number','avatar','url','title'], 'string'],
            [['created_at','updated_at','status','worth','expire'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'number' => '用户ID',
            'title' => '帖子ID',
            'url' => '链接',
            'avatar' => '头像',
            'updated_at' => 'Updated At',
            'created_at' => 'Updated At',
            'status' => '状态',
            'worth' => '价值',
            'expire' => '过期时间',

        ];
    }

    public function getPhotos(){

        $photo = Yii::$app->db->createCommand("select path from {{%weekly_content}} where album_id=$this->id")->queryAll();

        return $photo;
    }
    public function extraFields()
    {
        return [
            'photos'=>'photos',
        ];
    }
    // 返回的数据格式化
    public function fields()
    {
/*      $fields = parent::fields();
        $fields["dating_id"] = $fields['id'];
    //  remove fields that contain sensitive information
        unset($fields['id']);*/

        return [

            'dating_id'=>'id','number','title','created_at','avatar','status','worth','expire',
            'url'=>function($model){

                return explode('，',$model['url']);

            } ,
            'content'=>function($model){

                return explode('，',$model['content']);

            }

        ];

    }




}
