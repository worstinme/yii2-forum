<?php

use yii\helpers\Html;
use worstinme\uikit\Nav;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Html::encode($thread->name);


$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum', 'Forum'), 'url'=> ['/forum/default/index','lang'=>$lang]];
//$this->params['breadcrumbs'][] = ['label'=>$section->name, 'url'=> $section->url];
$this->params['breadcrumbs'][] = ['label'=>$forum->name, 'url'=> $forum->url];
$this->params['breadcrumbs'][] = $this->title;

?>
<section class="forum">

	<article class="thread thread-view forum-panel">

		<h1><?=$this->title?></h1>
		<?=$thread->content?>

		<div class="thread-info">
			<div class="author-avatar">
				<?= $thread->userAvatar?Html::img($thread->userAvatar,['class'=>'small-avatar']):Html::tag('i','',['class'=>'uk-icon-user small-avatar'])?>
			</div>
			<div class="thread-description">
				<?=Yii::t('forum','Author')?> <?= Html::a(!empty($thread->user->name)?$thread->user->name:Yii::t('forum','Deleted user'), !empty($thread->user->url)?$thread->user->url:'#', ['data'=>['pjax'=>0]]); ?>,
				<?=Yii::t('forum','Published')?> <?= Yii::$app->formatter->asRelativeTime($thread->created_at) ?>
			
				<?= Nav::widget([
					'options'=>['class'=>'uk-subnav-line'],
					'navClass'=>'uk-subnav',
					'items' => [ 
						['label' =>Yii::t('forum','Reply'),'url' => '#reply','linkOptions'=>['data-uk-smooth-scroll'=>""]],
					    ['label' =>Yii::t('forum','Edit thread'),'url' => $thread->editUrl,'visible'=>$thread->canEdit,'linkOptions'=>['data'=>['pjax'=>0]]],
					    ['label' =>Yii::t('forum','Delete thread'),'url' => $thread->deleteUrl,'visible'=>$thread->canDelete,'linkOptions'=>['encode'=>false,'data'=>['pjax'=>0,'method'=>'post','confirm'=>Yii::t('forum','Sure to delete?')]]],
					    ['label' =>Yii::t('forum',$thread->flag?'Unlock thread':'Lock thread'),'url' => $thread->lockUrl,'visible'=>$thread->canEdit,'linkOptions'=>['data'=>['pjax'=>0,'method'=>'post']]],
					],
				]); ?>
			</div>
		</div>

	</article>


	<?php Pjax::begin(['id'=>'posts','timeout'=>5000,'options'=>['class'=>'uk-margin-top','data-uk-observe'=>true]]); ?>    
		<?= ListView::widget([
	        'dataProvider' => $postProvider,
	        'options'=>['class'=>'thread-posts uk-margin-top'],
	        'itemOptions' => ['class' => 'thread-post forum-panel'],
	        'summaryOptions'=>['class'=>'uk-margin-top'],
	        'layout'=>'{pager}{items}{summary}{pager}',
	        'itemView' => '_post',
	        'pager'=>[
	        	'class'=> 'worstinme\uikit\widgets\LinkPager',
	        	'options'=>['class'=>'uk-pagination']
	        ],
	    ]) ?>
	<?php Pjax::end(); ?>

	<hr>

	<?php if ($thread->isReplyEnabled): ?>
		
		<?php if (Yii::$app->user->isGuest): ?>
			<?= Html::a(Yii::t('forum','Sign up to reply the thread'), Yii::$app->user->loginUrl); ?>
		<?php else: ?>
		<?php Pjax::begin(['id'=>'reply','timeout'=>5000,'options'=>['data-uk-observe'=>true]]); ?> 
			<?=$this->render('_reply',[
				'model'=>$post,
				'thread'=>$thread,
			]); ?>
		<?php Pjax::end(); ?>
		<?php endif ?>

	<?php endif ?>

</section>

<?php  $script = <<<JS

$.pjax.defaults.scrollTo = false;

$("#reply").on("pjax:end",function(){ 
    $.pjax.reload({container: '#posts', timeout: 2000});
;})

	
JS;

$this->registerJs($script,$this::POS_READY);