<?php

namespace worstinme\forum\frontend\models;

use Yii;

/**
 * This is the model class for table "forum_sections".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property integer $state
 * @property integer $sort
 * @property string $metaTitle
 * @property string $metaDescription
 * @property string $metaKeywords
 */
class Sections extends \yii\db\ActiveRecord
{
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
            [['name', 'alias'], 'required'],
            [['description', 'metaDescription'], 'string'],
            [['state', 'sort'], 'integer'],
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

    public function getForums()
    {
        return $this->hasMany(Forums::className(), ['section_id' => 'id'])->where(['state'=>1])->inverseOf('section');
    }
}
