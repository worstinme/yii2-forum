<?php

namespace worstinme\forum\backend\models;

use Yii;

/**
 * This is the model class for table "forum_tags".
 *
 * @property integer $thread_id
 * @property string $tag
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'tag'], 'required'],
            [['thread_id'], 'integer'],
            [['tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'thread_id' => Yii::t('forum', 'Thread ID'),
            'tag' => Yii::t('forum', 'Tag'),
        ];
    }
}
