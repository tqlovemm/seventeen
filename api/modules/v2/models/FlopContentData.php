<?php

namespace api\modules\v2\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "pre_flop_content_data".
 *
 * @property integer $id
 * @property string $content
 * @property string $priority
 * @property integer $user_id
 * @property string $flag
 * @property integer $created_at
 * @property integer $updated_at
 */
class FlopContentData extends ActiveRecord
{
    public $append;

    public static function tableName()
    {
        return '{{%flop_content_data}}';
    }

    public function getId()
    {
        return $this->id;
    }

    public function rules()
    {
        return [

            [['created_at', 'updated_at','user_id','append'], 'integer'],
            [['content', 'priority','flag'], 'string'],
        ];
    }


    public function fields()
    {
/*        $fields = parent::fields();
        $fields["flop_content_data_id"] = $fields['id'];*/
        // remove fields that contain sensitive information

  /*      unset($fields['id']);
        return $fields;*/

        return [

            'flop_content_data_id'=>'id','user_id',

            'content'=>function($model){

                $content = array_filter(explode(',',$model->content));


                $contents = array();

                foreach($content as $item){

                    $photo = Yii::$app->db->createCommand("select id as flop_content_id,path from {{%flop_content}} WHERE id=$item")->queryOne();

                    if(!empty($photo)){

                        array_push($contents,$photo);
                    }
                }
                return $contents;

            },

            'priority'=>function($model){

                $content = array_filter(explode(',',$model->priority));


                $contents = array();

                foreach($content as $item){

                    $photo = Yii::$app->db->createCommand("select id as flop_content_id,path from {{%flop_content}} WHERE id=$item")->queryOne();

                    if(!empty($photo)){

                        array_push($contents,$photo);
                    }
                }
                return $contents;

            },
            'created_at','updated_at','flag',

        ];

    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'priority' => '翻牌',
            'flag' => '标识',
            'user_id' => '用户ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
