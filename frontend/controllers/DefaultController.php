<?php

namespace worstinme\forum\frontend\controllers;

use Yii;
use yii\web\Controller;
use worstinme\forum\frontend\models\Sections;
use worstinme\forum\frontend\models\Forums;
use worstinme\forum\frontend\models\ThreadsSearch;
use yii\web\NotFoundHttpException;
/**
 * Default controller for the `forum-backend` module
 */
class DefaultController extends Controller
{
    public $lang;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only'=>['section-create','forum-create'],
                'rules' => [
                    [
                        'actions' => ['section-create','forum-create'],
                        'allow' => true,
                        'roles' => ['admin','moder','section-create','forum-create'],
                    ],
                ],
            ],
        ];
    }

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

        if (in_array($action->id, ['index','forum'])) {
            \yii\helpers\Url::remember();
        }

        return true; 
    }

    public function render($view, $params = [])
    {
        \worstinme\forum\assets\Asset::register($this->view);
        return parent::render($view, $params);
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
            'lang'=>$this->lang,
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

    public function actionSectionCreate($id = null)
    {
 
        if (($model = Sections::findOne($id)) === null) {
            $model = new Sections;
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'lang' => $model->lang]);
        } else {
            return $this->render('section-create', [
                'model' => $model,
                'lang'=>$this->lang,
            ]);
        }
    }


    public function actionForumCreate($id = null, $section_id = null)
    {
        if (($model = Forums::findOne($id)) === null) {
            $model = new Forums(['section_id'=>$section_id]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($model->url);
        } else {

            $sections = Sections::find()->select(['name'])->indexBy('id')->column();

            return $this->render('forum-create', [
                'model' => $model,
                'lang'=>$this->lang,
                'sections'=>$sections,
            ]);
        }
    }

}
