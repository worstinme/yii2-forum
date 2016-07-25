<?php

namespace worstinme\forum\backend\models;

use Yii;

/**
 * This is the model class for table "forum_posts".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $name
 * @property string $content
 * @property integer $state
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 */
class Posts extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'name', 'user_id'], 'required'],
            [['thread_id', 'state', 'created_at', 'updated_at', 'user_id'], 'integer'],
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
            'thread_id' => Yii::t('forum', 'Thread ID'),
            'name' => Yii::t('forum', 'Name'),
            'content' => Yii::t('forum', 'Content'),
            'state' => Yii::t('forum', 'State'),
            'created_at' => Yii::t('forum', 'Created At'),
            'updated_at' => Yii::t('forum', 'Updated At'),
            'user_id' => Yii::t('forum', 'User ID'),
        ];
    }
}
