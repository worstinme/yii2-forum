<?php

namespace worstinme\forum\backend; 

use Yii;
/**
 * forum-backend module definition class
 */
class Module extends \yii\base\Module
{
    public $languages = ['en'=>'English'];
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'worstinme\forum\backend\controllers';

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
            'sourceLanguage' => 'ru-RU',
            'basePath' => '@worstinme/forum/messages',
        ];
    }
}
