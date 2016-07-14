<?php

namespace worstinme\forum\backend\models;

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

    public function behaviors()
    {
        return [
            [
                'class' => \worstinme\uikit\AliasBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'alias',
                'ensureUnique'=>true,
                'immutable'=>true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'name'], 'required'],
            [['section_id', 'state', 'sort'], 'integer'],
            [['description', 'metaDescription'], 'string'],
            [['name', 'alias', 'metaTitle', 'metaKeywords'], 'string', 'max' => 255],
            ['lang','in', 'range' => array_keys(Yii::$app->controller->module->languages) ]
        ];
    }

    public function getSection()
    {
        return $this->hasOne(Sections::className(), ['id' => 'section_id'])->inverseOf('forums');
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
}
