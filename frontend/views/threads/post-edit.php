<?php

use yii\helpers\Html;
use worstinme\uikit\ActiveForm;

$this->title = Yii::t('forum', 'Post Edit');
$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum', 'Forum'), 'url'=> ['/forum/default/index','lang'=>Yii::$app->language]];
$this->params['breadcrumbs'][] = ['label'=>$model->thread->forum->name, 'url'=> $model->thread->forum->url];
$this->params['breadcrumbs'][] = ['label'=>$model->thread->name, 'url'=> $model->thread->url];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forums-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="post-reply">

        <?= $this->render('_reply', [
            'model'=>$model,
        ])?>

    </div>

</div>
