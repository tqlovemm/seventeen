<?php

namespace frontend\modules\member\models;

use Yii;

/**
 * This is the model class for table "pre_auto_joining_link".
 *
 * @property integer $id
 * @property string $remarks
 * @property string $flag
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property AutoJoinFilesText[] $autoJoiningFilesTexts
 */
class AutoJoinLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_auto_joining_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['remarks'], 'string', 'max' => 256],
            [['flag'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'remarks' => 'Remarks',
            'flag' => 'Flag',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoJoiningFilesTexts()
    {
        return $this->hasMany(AutoJoinFilesText::className(), ['link_id' => 'id']);
    }
}
