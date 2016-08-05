<?php

use yii\helpers\Html;
use worstinme\uikit\Nav;

?>

<?= Nav::widget([
	'id'=>'post-'.$model->id,
	'options'=>['class'=>'uk-subnav-line post-header'],
	'navClass'=>'uk-subnav',
	'items' => [ 
		['label'=>$model->userAvatar?Html::img($model->userAvatar):Html::tag('i','',['class'=>'uk-icon-user']),'options'=>['class'=>'small-avatar'] ], 
		['label'=>!empty($model->user->name)?$model->user->name:Yii::t('forum','Deleted user'),'url'=>!empty($model->user->url)?$model->user->url:'#','linkOptions'=>['class'=>'author','data'=>['pjax'=>0]]],
		['label'=>Yii::$app->formatter->asRelativeTime($model->created_at)],
	    ['label' =>Yii::t('forum','Edit post'),'url' => $model->editUrl,'visible'=>$model->canEdit,'linkOptions'=>['data'=>['pjax'=>0]]],
	    ['label' =>Yii::t('forum','Delete post'),'url' => $model->deleteUrl,'visible'=>$model->canDelete,'linkOptions'=>['encode'=>false,'data'=>['method'=>'post','confirm'=>Yii::t('forum','Sure,	 delete post?')]]],
	],
]); ?> 

<div class="post-content">
	<?=$model->content?>
</div>