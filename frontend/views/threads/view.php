<?php

use yii\helpers\Html;
use worstinme\uikit\Nav;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Html::encode($thread->name);


$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum','Форум'), 'url'=> ['/forum/default/index','lang'=>$lang]];
//$this->params['breadcrumbs'][] = ['label'=>$section->name, 'url'=> $section->url];
$this->params['breadcrumbs'][] = ['label'=>$forum->name, 'url'=> $forum->url];
$this->params['breadcrumbs'][] = $this->title;

?>

<article class="thread thread-view forum-panel">

	<div class="uk-grid uk-grid-small">
		<div class="uk-width-4-5">
			<h1><?=$this->title?></h1>
			<?=$thread->content?>
		</div>
		<div class="uk-width-1-5">
			<div class="author-avatar">
				<?=!empty($thread->user->avatar) ? Html::img($thread->user->avatar,['class'=>'small-avatar']) : Html::tag('i','',['class'=>'uk-icon-user small-avatar'])?>
			</div>
			<div class="author-name">
				<?= Html::a($thread->user->name, $thread->user->url, ['data'=>['pjax'=>0]]); ?>
			</div>
		</div>
	</div>

	<?= Nav::widget([
		'options'=>['class'=>'uk-subnav-line thread-info uk-margin-top'],
		'navClass'=>'uk-subnav',
		'items' => [ 
			['label'=>Yii::$app->formatter->asRelativeTime($thread->created_at)],
		    ['label' =>Yii::t('forum','Edit thread'),'url' => $thread->editUrl,'visible'=>$thread->canEdit,'linkOptions'=>['data'=>['pjax'=>0]]],
		    ['label' =>Yii::t('forum','Delete thread'),'url' => $thread->deleteUrl,'visible'=>$thread->canDelete,'linkOptions'=>['encode'=>false,'data'=>['pjax'=>0,'method'=>'post','confirm'=>Yii::t('forum','Sure to delete?')]]],
		],
	]); ?> 

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

<?php if ($thread->state == $thread::STATE_ACTIVE): ?>
	
	<?php if (Yii::$app->user->isGuest): ?>
		<?= Html::a(Yii::t('forum','Reply to the thread'), $thread->replyUrl); ?>
	<?php else: ?>
	<?php Pjax::begin(['id'=>'reply','timeout'=>5000,'options'=>['data-uk-observe'=>true]]); ?> 
		<?=$this->render('_reply',[
			'model'=>$post,
			'thread'=>$thread,
		]); ?>
	<?php Pjax::end(); ?>
	<?php endif ?>

<?php endif ?>

<?php  $script = <<<JS

$.pjax.defaults.scrollTo = false;

$("#reply").on("pjax:end",function(){ 
    $.pjax.reload({container: '#posts', timeout: 2000});
;})

	
JS;

$this->registerJs($script,$this::POS_READY);