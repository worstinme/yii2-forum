<?php

use yii\helpers\Html;
use worstinme\uikit\widgets\ListView;
use yii\widgets\Pjax;
use worstinme\uikit\Nav;

$this->title = $forum->title;

\worstinme\uikit\assets\Accordion::register($this);

$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum', 'Forum'), 'url'=> ['/forum/default/index','lang'=>$lang]];
$this->params['breadcrumbs'][] = $this->title;

?>

<section class="forum">

    <article class="forum-view forum-panel">

    <h1><?=$this->title?></h1>

    <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->can('moder') || Yii::$app->user->can('admin'))): ?>
    
        <?= Nav::widget([
            'options'=>['class'=>'uk-subnav-line uk-margin-top post-header'],
            'navClass'=>'uk-subnav',
            'encodeLabels'=>false,
            'items' => [ 
                ['label' =>Yii::t('forum','Edit forum'),'url' =>['/forum/default/forum-create','lang'=>$lang,'id'=>$forum->id]],
                ['label' =>Yii::t('forum','Activate forum'),'linkOptions'=>['data'=>['method'=>'post']],'url' =>['/forum/default/forum-activate','lang'=>$lang,'id'=>$forum->id],'visible'=>$forum->state == $forum::STATE_HIDDEN],
                ['label' =>Yii::t('forum','Hide forum'),'linkOptions'=>['data'=>['method'=>'post']],'url' =>['/forum/default/forum-delete','lang'=>$lang,'id'=>$forum->id],'visible'=>$forum->state == $forum::STATE_ACTIVE],
                ['label' =>Yii::t('forum','Delete forum'),'linkOptions'=>['data'=>['method'=>'post','confirm'=>Yii::t('forum','Sure to delete?')]],'url' =>['/forum/default/forum-delete','lang'=>$lang,'id'=>$forum->id],'visible'=>$forum->state == $forum::STATE_HIDDEN],
                
            ],
        ]); ?> 

    <?php endif ?>

    <?=$forum->description?>

    </article>

    <?php Pjax::begin(); ?>    
    	
    	<?= ListView::widget([
            'dataProvider' => $dataProvider,
            'options'=>['class'=>'forum-threads'],
            'layout'=>'<div class="forum-threads-box">{items}</div><div class="uk-margin-top">{pager}</div>',
            'itemOptions' => ['class' => 'thread'],
            'itemView' => '_thread',
        ]) ?>

    <?php Pjax::end(); ?>

    <div class="uk-margin-top">

        <?= Html::a(Yii::t('forum','Create new thread'),
            ['/forum/threads/new-thread','lang'=>$lang,'forum_id'=>$forum->id],
            ['class' => 'uk-button uk-button-small uk-button-success']); ?>


    </div>

</section>

<?php  $script = <<<JS

	
JS;

$this->registerJs($script,$this::POS_READY);