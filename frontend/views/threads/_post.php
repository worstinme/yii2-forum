<?php

use yii\helpers\Html;
use worstinme\uikit\Nav;

?>

<?= Nav::widget([
	'id'=>'post-'.$model->id,
	'options'=>['class'=>'uk-subnav-line post-header'],
	'navClass'=>'uk-subnav',
	'items' => [ 
		['label'=>!empty($model->user->avatar) ? Html::img($model->user->avatar,['class'=>'small-avatar']) : Html::tag('i','',['class'=>'uk-icon-user small-avatar']) ], 
		['label'=>$model->user->name,'url'=>$model->user->url,'linkOptions'=>['class'=>'author','data'=>['pjax'=>0]]],
		['label'=>Yii::$app->formatter->asRelativeTime($model->created_at)],
	    ['label' =>Yii::t('forum','Edit post'),'url' => $model->editUrl,'visible'=>$model->canEdit,'linkOptions'=>['data'=>['pjax'=>0]]],
	    ['label' =>Yii::t('forum','Delete post'),'url' => $model->deleteUrl,'visible'=>$model->canDelete,'linkOptions'=>['encode'=>false,'data'=>['pjax'=>0,'method'=>'post','confirm'=>Yii::t('forum','Sure to delete?')]]],
	],
]); ?> 

<div class="post-content">
	<?=$model->content?>
</div>