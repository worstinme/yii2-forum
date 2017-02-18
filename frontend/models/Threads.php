<?php

namespace worstinme\forum\frontend\models;

use Yii;

class Threads extends \yii\db\ActiveRecord
{
    const STATE_DELETED = 0;
    const STATE_WAIT = 10;
    const STATE_REJECTED = 11;
    const STATE_ACTIVE = 1;

    const FLAG_ACTIVE = 1;
    const FLAG_INACTIVE = 0;

    const DELAY_TO_EDIT = 60*60;
    const DELAY_TO_DELETE = 60*5;

    public $_forum;

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
            [['name','content'], 'required'],
            [['content'], 'string'],
            [['views','flag','related_id'],'integer'],
            [['content'],'filter','filter'=>'\worstinme\forum\helpers\HtmlPurifier::filter'],
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
            'name' => Yii::t('forum', 'Thread title'),
            'content' => Yii::t('forum', 'Thread content'),
            'flag' => Yii::t('forum', 'Flag'),
            'state' => Yii::t('forum', 'State'),
            'created_at' => Yii::t('forum', 'Created At'),
            'updated_at' => Yii::t('forum', 'Updated At'),
            'user_id' => Yii::t('forum', 'User ID'),
        ];
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];

    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

            if ($insert) {
                $this->user_id = Yii::$app->user->identity->id;
                $this->state = $this::STATE_ACTIVE;
            }

            return true;
        }
        else return false;
    }

    public function getForum()
    {
        return $this->hasOne(Forums::className(), ['id' => 'forum_id'])->inverseOf('threads');
    }

    public function getUser()
    {
        $module = Yii::$app->getModule('forum');
        return $this->hasOne($module->profileModel, [$module->profileModelUserColumn => 'user_id']);
    }

    public function getUserAvatar() {
        $module = Yii::$app->getModule('forum');
        return !empty($this->user) ? $this->user->{$module->profileAvatarAttribute} : null;
    }


    public function getRelatedItem() {
        if(Yii::$app->controller->module->relatedModel !== null) {
            return $this->hasOne(Yii::$app->controller->module->relatedModel,['id'=>'related_id']);
        }
    }

    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['thread_id' => 'id'])->where(['state'=>Posts::STATE_ACTIVE])->orderBy('created_at')->inverseOf('thread');
    }

    public function getLastPost()
    {
        return $this->hasOne(Posts::className(), ['thread_id' => 'id'])->where(['state'=>Posts::STATE_ACTIVE])->orderBy('created_at DESC')->inverseOf('thread');
    }

    public function getCanEdit() {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        elseif (Yii::$app->user->can('admin') || Yii::$app->user->can('moder')) {
            return true;
        }
        elseif($this->state != $this::STATE_DELETED && Yii::$app->user->identity->id == $this->user_id && ($this->created_at + Yii::$app->controller->module->threadEditDelay) >= time()) {
            return true;
        }
        return false;
    }

    public function getCanDelete() {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        elseif (Yii::$app->user->can('admin') || Yii::$app->user->can('moder')) {
            return true;
        }
        elseif($this->state != $this::STATE_DELETED && Yii::$app->user->identity->id == $this->user_id && ($this->created_at + Yii::$app->controller->module->threadDeleteDelay) >= time()) {
            return true;
        }
        return false;
    }

    public function getIsReplyEnabled() {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('moder')) {
            return true;
        }
        elseif($this->state == $this::STATE_ACTIVE) {
            return true;
        }
        return false;
    }

    public function getLastPage($perPage) {
        $perPage = !empty($perPage)?$perPage:Yii::$app->controller->module->postPageSize;
        return ceil($this->getPosts()->count() / $perPage) - 1;
    }

    public function getUrl($url = []) {
        return array_merge(['/forum/threads/view','thread_id'=>$this->id,'forum'=>$this->forum->alias,'section'=>$this->forum->section->alias,'lang'=>$this->forum->lang],$url);
    }

    public function getEditUrl() {
        return ['/forum/threads/edit','thread_id'=>$this->id,'forum'=>$this->forum->alias,'section'=>$this->forum->section->alias,'lang'=>$this->forum->lang];
    }

    public function getDeleteUrl() {
        return ['/forum/threads/delete','thread_id'=>$this->id,'lang'=>$this->forum->lang];
    }

    public function getLockUrl() {
        return ['/forum/threads/lock','thread_id'=>$this->id,'lang'=>$this->forum->lang];
    }

    public function getReplyUrl() {
        return ['/forum/threads/reply','thread_id'=>$this->id,'forum'=>$this->forum->alias,'section'=>$this->forum->section->alias,'lang'=>$this->forum->lang];
    }

}
