<?php

use yii\helpers\Html;
use worstinme\uikit\Nav;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use himiklab\thumbnail\EasyThumbnailImage;

\worstinme\uikit\assets\Lightbox::register($this);

$this->title = Html::encode($thread->name);


$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum', 'Forum'), 'url'=> ['/forum/default/index','lang'=>$lang]];
//$this->params['breadcrumbs'][] = ['label'=>$section->name, 'url'=> $section->url];
$this->params['breadcrumbs'][] = ['label'=>$forum->name, 'url'=> $forum->url];
$this->params['breadcrumbs'][] = $this->title;

?>
<section class="forum">

	<article class="thread thread-view forum-panel">

		<h1><?=$this->title?></h1>

		<div class="thread-content">
			<?=$thread->content?>
		</div>

		<?php if($thread->relatedItem !== null): ?>
		<div class="thread-related-info">
			<h3>
				<?= EasyThumbnailImage::thumbnailImg('@webroot'.$thread->relatedItem->image,40,40, EasyThumbnailImage::THUMBNAIL_OUTBOUND)?>
				<?= Html::a($thread->relatedItem->name,$thread->relatedItem->url , ['title'=>$thread->relatedItem->name,'target'=>'_blank','data-pjax'=>0]); ?>
			</h3>

		</div>
		<?php endif ?>

		<div class="thread-info">
			<div class="author-avatar">
				<?= $thread->userAvatar?Html::img($thread->userAvatar,['class'=>'small-avatar']):Html::tag('i','',['class'=>'uk-icon-user small-avatar'])?>
			</div>
			<div class="thread-description">
				<?=Yii::t('forum','Author')?> <?= Html::a(!empty($thread->user->name)?$thread->user->name:Yii::t('forum','Deleted user'), !empty($thread->user->url)?$thread->user->url:'#', ['data'=>['pjax'=>0]]); ?>,
				<?php if($thread->updated_at != $thread->created_at): ?>
					<?=Yii::t('forum','updated')?>
					<?= (time() - $thread->updated_at < 600000) ? Yii::$app->formatter->asRelativeTime($thread->updated_at) : Yii::$app->formatter->asDate($thread->updated_at,'php:d.m.Y') ?>,
				<?php endif ?>
				<?=Yii::t('forum','published')?>
				<?= (time() - $thread->created_at < 600000) ? Yii::$app->formatter->asRelativeTime($thread->created_at) : Yii::$app->formatter->asDate($thread->created_at,'php:d.m.Y') ?>


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

$("body").on("click",".thread-content img, .post-content img",function(){
    var img_url = $(this).attr("src");
    UIkit.lightbox.create([
		{'source': img_url, 'type':'image'}
	]).show();
});

	
JS;

$this->registerJs($script,$this::POS_READY);