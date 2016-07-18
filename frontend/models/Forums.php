<?php

namespace worstinme\forum\frontend\models;

use Yii;

/**
 * This is the model class for table "forum_forums".
 *
 * @property integer $id
 * @property integer $section_id
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property integer $state
 * @property integer $sort
 * @property string $metaTitle
 * @property string $metaDescription
 * @property string $metaKeywords
 */
class Forums extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_forums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'name', 'alias'], 'required'],
            [['section_id', 'state', 'sort'], 'integer'],
            [['description', 'metaDescription'], 'string'],
            [['name', 'alias', 'metaTitle', 'metaKeywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forum', 'ID'),
            'section_id' => Yii::t('forum', 'Section ID'),
            'name' => Yii::t('forum', 'Name'),
            'alias' => Yii::t('forum', 'Alias'),
            'description' => Yii::t('forum', 'Description'),
            'state' => Yii::t('forum', 'State'),
            'sort' => Yii::t('forum', 'Sort'),
            'metaTitle' => Yii::t('forum', 'Meta Title'),
            'metaDescription' => Yii::t('forum', 'Meta Description'),
            'metaKeywords' => Yii::t('forum', 'Meta Keywords'),
        ];
    }

    public function getSection()
    {
        return $this->hasOne(Sections::className(), ['id' => 'section_id'])->inverseOf('forums');
    }

    public function getThreads()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('moder')) {
            return $this->hasMany(Threads::className(), ['forum_id' => 'id'])->inverseOf('forum');
        }
        
        return $this->hasMany(Threads::className(), ['forum_id' => 'id'])->where(['forum_threads.state'=>Threads::STATE_ACTIVE])->inverseOf('forum');
    }

    public function getLastThreads()
    {
        return $this->hasMany(Threads::className(), ['forum_id' => 'id'])->where(['forum_threads.state'=>Threads::STATE_ACTIVE])->limit(3)->inverseOf('forum');
    }

    public function getUrl() {
        return ['/forum/default/forum','section'=>$this->section->alias,'forum'=>$this->alias,'lang'=>$this->lang];
    }

    public function getTitle() {
        return !empty($this->metaTitle)?$this->metaTitle:$this->name;
    }
}
