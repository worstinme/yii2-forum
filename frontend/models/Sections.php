<?php

namespace worstinme\forum\frontend\models;

use Yii;

class Sections extends \yii\db\ActiveRecord
{
    const STATE_ACTIVE = 1;
    const STATE_HIDDEN = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_sections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias','lang'], 'required'],
            [['description', 'metaDescription'], 'string'],
            [['state', 'sort'], 'integer'],
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

    public function getUrl() {
        return ['/forum/default/section','section'=>$this->alias,'lang'=>$this->lang];
    }

    public function getForums()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('moder')) {
            return $this->hasMany(Forums::className(), ['section_id' => 'id'])->orderBy('sort')->inverseOf('section');
        }
        return $this->hasMany(Forums::className(), ['section_id' => 'id'])->where(['state'=>Forums::STATE_ACTIVE])->orderBy('sort')->inverseOf('section');
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
