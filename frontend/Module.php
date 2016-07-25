<?php

namespace worstinme\forum\frontend; 

use Yii;
/**
 * forum-backend module definition class
 */
class Module extends \yii\base\Module
{
    public $languages = ['en'=>'English'];
    public $postPageSize = 5;
    public $profileModel = '\app\models\Profile';
    public $moderRole = 'admin';
    public $profileModelUserColumn = 'id';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'worstinme\forum\frontend\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['forum'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@worstinme/forum/messages',
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/forum/' . $category, $message, $params, $language);
    }
}
