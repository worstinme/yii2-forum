<?php

namespace worstinme\forum\backend\models;

use Yii;

/**
 * This is the model class for table "forum_threads".
 *
 * @property integer $id
 * @property integer $forum_id
 * @property string $name
 * @property string $content
 * @property integer $flag
 * @property integer $state
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 */
class Threads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_threads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['forum_id', 'name', 'user_id'], 'required'],
            [['forum_id', 'flag', 'state', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forum', 'ID'),
            'forum_id' => Yii::t('forum', 'Forum ID'),
            'name' => Yii::t('forum', 'Name'),
            'content' => Yii::t('forum', 'Content'),
            'flag' => Yii::t('forum', 'Flag'),
            'state' => Yii::t('forum', 'State'),
            'created_at' => Yii::t('forum', 'Created At'),
            'updated_at' => Yii::t('forum', 'Updated At'),
            'user_id' => Yii::t('forum', 'User ID'),
        ];
    }

    public function getForum()
    {
        return $this->hasOne(Forums::className(), ['id' => 'forum_id'])->inverseOf('threads');
    }
}
