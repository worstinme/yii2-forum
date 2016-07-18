<?php

namespace worstinme\forum\frontend\controllers;

use Yii;
use yii\web\Controller;
use worstinme\forum\frontend\models\Sections;
use worstinme\forum\frontend\models\Forums;
use worstinme\forum\frontend\models\Threads;
use worstinme\forum\frontend\models\Posts;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

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

    public function actionView($section,$forum,$thread_id) {

        if (($section = Sections::findOne(['lang'=>$this->lang,'alias'=>$section])) !== null) {
            if (($forum = $section->getForums()->where(['alias'=>$forum])->one()) !== null) {
                if (($thread = $forum->getThreads()->where(['id'=>$thread_id])->one()) !== null) {

                    if (!(Yii::$app->user->can('admin') || Yii::$app->user->can('moder'))) {
                        throw new NotFoundHttpException('The requested page does not exist.');
                    }

                    if (!Yii::$app->session->has('thread-'.$thread->id.'-view')) {
                        $thread->views += 1;
                        $thread->save();
                        Yii::$app->session->set('thread-'.$thread->id.'-view',true);
                    }

                    $post = new Posts(['thread_id'=>$thread->id]);

                    if ($post->load(Yii::$app->request->post()) && $post->save()) {
                        Yii::$app->session->setFlash('success',Yii::t('forum','Your message was submitted.'));
                        $post = new Posts(['thread_id'=>$thread->id]);
                    }

                    $perPage = Yii::$app->request->get('per-page',Yii::$app->controller->module->postPageSize);

                    $postProvider = new ActiveDataProvider([
                        'query' => $thread->getPosts()->with(['user','thread','thread.forum','thread.forum.section']),
                        'pagination' => [
                            'pageSize' => $perPage
                        ],
                    ]);

                    if (Yii::$app->request->get('page') === null) {
                        $postProvider->pagination->page = $thread->getLastPage($perPage);
                    }

                    return $this->render('view',[
                        'lang'=>$this->lang,
                        'thread'=>$thread,
                        'forum'=>$forum,
                        'section'=>$section,
                        'post'=>$post,
                        'postProvider'=>$postProvider,
                    ]);
                }
            }
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionEdit($section,$forum,$thread_id) {

        if (($section = Sections::findOne(['lang'=>$this->lang,'alias'=>$section])) !== null) {
            if (($forum = $section->getForums()->where(['alias'=>$forum])->one()) !== null) {
                if (($model = $forum->getThreads()->where(['id'=>$thread_id])->one()) !== null) {

                    if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect($model->url);
                    }

                    return $this->render('edit',[
                        'lang'=>$this->lang,
                        'model'=>$model,
                        'forum'=>$forum,
                        'section'=>$section,
                    ]);
                }
            }
        }

        throw new NotFoundHttpException('The requested page does not exist.');

    }

    public function actionDelete($thread_id) {

        $model = Threads::findOne($thread_id);

        if (Yii::$app->user->can('admin')) {

            if ($model->state == $model::STATE_DELETED) {

                $forum = $model->forum->alias;
                $section = $model->forum->section->alias;

                $model->delete();

                Yii::$app->session->setFlash('success', Yii::t('forum',"Thread has just been removed."));

                return $this->redirect(['/forum/default/forum','forum'=>$forum,'section'=>$section,'lang'=>$model->forum->lang]);
            }
            else {

                $model->updateAttributes(['state'=>$model::STATE_DELETED]);

                Yii::$app->session->setFlash('success', Yii::t('forum',"Thread has been marked as DELETED."));

            }

            return $this->redirect($model->url);

        } 
        elseif(Yii::$app->user->identity->id == $model->user_id) {
            


            return $this->redirect($model->url);
        }
        else {

            Yii::$app->session->setFlash('error', Yii::t('forum',"You havn't enough right to remove threads"));
            return $this->redirect($model->url);

        }

    }



    public function actionNewThread() {

        $model = new Threads;

        $model->forum_id = Yii::$app->request->get('forum_id');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($model->url);
        }

        return $this->render('edit',[
            'model'=>$model,
            'lang'=>$this->lang,
        ]);
    }



}