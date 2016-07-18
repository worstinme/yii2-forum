<?php

namespace worstinme\forum\frontend\controllers;

use Yii;
use yii\web\Controller;
use worstinme\forum\frontend\models\Sections;
use worstinme\forum\frontend\models\ThreadsSearch;
use yii\web\NotFoundHttpException;
/**
 * Default controller for the `forum-backend` module
 */
class DefaultController extends Controller
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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $sections = Sections::find()->where(['lang'=>$this->lang,'state'=>1])->all();

        return $this->render('index',[
            'sections'=>$sections,
        ]);
    }

    public function actionForum($lang,$section,$forum)
    {

        if (($section = Sections::findOne(['lang'=>$this->lang,'alias'=>$section])) !== null) {
            if (($forum = $section->getForums()->where(['alias'=>$forum])->one()) !== null) {

                $searchModel = new ThreadsSearch();
                $searchModel->_query = $forum->getThreads()->with(['lastPost','forum','forum.section','user']);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('forum',[
                    'lang'=>$this->lang,
                    'forum'=>$forum,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
        }

        throw new NotFoundHttpException('The requested page does not exist.');
        
    }
}
