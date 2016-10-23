<?php

namespace worstinme\forum\frontend\models;

use Yii;

class Forums extends \yii\db\ActiveRecord
{
    const STATE_ACTIVE = 1;
    const STATE_HIDDEN = 0;
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
            [['section_id', 'name', 'alias','lang'], 'required'],
            [['section_id', 'state', 'sort'], 'integer'],
            [['description', 'metaDescription'], 'string'],
            [['name', 'alias', 'metaTitle', 'metaKeywords','lang'], 'string', 'max' => 255],
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
        return $this->hasMany(Threads::className(), ['forum_id' => 'id'])->inverseOf('forum');
    }

    public function getLastThreads()
    {
        return $this->hasMany(Threads::className(), ['forum_id' => 'id'])->where(['forum_threads.state'=>Threads::STATE_ACTIVE])->orderBy('flag DESC, updated_at DESC')->limit(3)->inverseOf('forum');
    }

    public function getUrl() {
        return ['/forum/default/forum','section'=>$this->section->alias,'forum'=>$this->alias,'lang'=>$this->lang];
    }

    public function getTitle() {
        return !empty($this->metaTitle)?$this->metaTitle:$this->name;
    }

    public function getCanEdit() {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        elseif (Yii::$app->user->can('admin') || Yii::$app->user->can('moder')) {
            return true;
        }
        return false;
    }

    public function getCanDelete() {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        elseif (Yii::$app->user->can('admin')) {
            return true;
        }
        return false;
    }
    
}
