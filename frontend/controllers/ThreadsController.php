<?php

namespace worstinme\forum\frontend\controllers;

use Yii;
use yii\web\Controller;
use worstinme\forum\frontend\models\Sections;
use worstinme\forum\frontend\models\Forums;
use worstinme\forum\frontend\models\Threads;

class ThreadsController extends Controller
{
    public $lang;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $lang = Yii::$app->request->get('lang');

        if (in_array($lang, array_keys($this->module->languages))) {
            $this->lang = $lang;
            Yii::$app->language = $lang;
        }

        return true; 
    }

    public function actionNewThread() {

        $model = new Threads;

        return $this->render('new-thread',[
            'model'=>$model,
            'lang'=>$this->lang,
        ]);
    }

}