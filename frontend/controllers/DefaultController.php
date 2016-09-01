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
                'only'=>['section-create','forum-create','section-delete','section-activate','forum-delete','forum-activate'],
                'rules' => [
                    [
                        'actions' => ['section-create','forum-create','section-delete','section-activate','forum-delete','forum-activate'],
                        'allow' => true,
                        'roles' => ['admin','moder','section','forum'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'section-delete' => ['POST'],
                    'section-activate' => ['POST'],
                    'forum-delete' => ['POST'],
                    'forum-activate' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        

        $lang = substr(Yii::$app->request->get('lang'), 0, 2);

        if ($this->module->processLanguageSetting && $lang !== null && in_array($lang, array_keys($this->module->languages))) {
            $this->lang = $lang;
            Yii::$app->language = $lang;
        } else {
            $this->lang = substr(Yii::$app->language, 0, 2);
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
        

        if (!Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('moder'))) {
            $sections = Sections::find()->where(['lang'=>$this->lang])->orderBy('sort')->all();
        }
        else {
            $sections = Sections::find()->where(['lang'=>$this->lang,'state'=>Sections::STATE_ACTIVE])->orderBy('sort')->all();
        }
        

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

    public function actionSectionDelete($id) {

        if (($model = Sections::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->state == $model::STATE_HIDDEN && $model->canDelete) {

            $model->delete();

            Yii::$app->session->setFlash('success', Yii::t('forum',"Section has just been removed."));

            return $this->redirect(['/forum/default/index','lang'=>$model->lang]);
        }
        elseif ($model->state == $model::STATE_ACTIVE && $model->canEdit) {

            $model->updateAttributes(['state'=>$model::STATE_HIDDEN]);
            Yii::$app->session->setFlash('success', Yii::t('forum',"Section has been hidden."));

            return $this->redirect(['index','lang'=>$this->lang]);

        }

        Yii::$app->session->setFlash('error', Yii::t('forum',"Mission impossible"));
        
        return $this->redirect(['index','lang'=>$this->lang]);

    }

    public function actionSectionActivate($id) {

        if (($model = Sections::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->state == $model::STATE_HIDDEN && $model->canEdit) {

            $model->updateAttributes(['state'=>$model::STATE_ACTIVE]);
            Yii::$app->session->setFlash('success', Yii::t('forum',"Section has been activated."));

            return $this->redirect(['index','lang'=>$this->lang]);

        }

        Yii::$app->session->setFlash('error', Yii::t('forum',"Mission impossible"));
        
        return $this->redirect($model->url);

    }

    public function actionForumDelete($id) {

        if (($model = Forums::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->state == $model::STATE_HIDDEN && $model->canDelete) {

            $model->delete();

            Yii::$app->session->setFlash('success', Yii::t('forum',"Forum has just been removed."));

            return $this->redirect(['/forum/default/index','lang'=>$model->lang]);
        }
        elseif ($model->state == $model::STATE_ACTIVE && $model->canEdit) {

            $model->updateAttributes(['state'=>$model::STATE_HIDDEN]);
            Yii::$app->session->setFlash('success', Yii::t('forum',"Forum has been hidden."));

            return $this->redirect($model->url);

        }

        Yii::$app->session->setFlash('error', Yii::t('forum',"Mission impossible"));
        
        return $this->redirect($model->url);

    }

    public function actionForumActivate($id) {

        if (($model = Forums::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->state == $model::STATE_HIDDEN && $model->canEdit) {

            $model->updateAttributes(['state'=>$model::STATE_ACTIVE]);
            Yii::$app->session->setFlash('success', Yii::t('forum',"Forum has been activated."));

            return $this->redirect($model->url);

        }

        Yii::$app->session->setFlash('error', Yii::t('forum',"Mission impossible"));
        
        return $this->redirect($model->url);

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
