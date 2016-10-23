<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use himiklab\thumbnail\EasyThumbnailImage;

$postCount = $model->getPosts()->count();

?>
<div class="thread-panel">
	<div class="uk-grid uk-grid-small">
		<div class="uk-width-medium-2-3">
			<?php if($model->relatedItem !== null): ?>
				<?= Html::a(EasyThumbnailImage::thumbnailImg('@webroot'.$model->relatedItem->image,40,40, EasyThumbnailImage::THUMBNAIL_OUTBOUND),$model->relatedItem->url , ['title'=>$model->relatedItem->name,'target'=>'_blank','class'=>'uk-float-right','data-pjax'=>0]); ?>
			<?php endif ?>
			<h2><?php if ($model->flag): ?><i class="uk-icon-star"></i> <?php endif ?><?=$model->state==$model::STATE_DELETED?'<em>DELETED: </em>':''?><?= Html::a($model->name, $model->url,['data'=>['pjax'=>0]]); ?></h2>
			<p class="meta">
				<?=Yii::t('forum','Author')?> <?= Html::a(!empty($model->user->name)?$model->user->name:Yii::t('forum','Deleted user'), !empty($model->user->url)?$model->user->url:'#',['data'=>['pjax'=>0]]); ?>,
				<?php if($model->updated_at != $model->created_at): ?>
					<?=Yii::t('forum','updated')?>
					<?= (time() - $model->updated_at < 600000) ? Yii::$app->formatter->asRelativeTime($model->updated_at) : Yii::$app->formatter->asDate($model->updated_at,'php:d.m.Y') ?>,
				<?php endif ?>
				<?=Yii::t('forum','published')?>
				<?= (time() - $model->created_at < 600000) ? Yii::$app->formatter->asRelativeTime($model->created_at) : Yii::$app->formatter->asDate($model->created_at,'php:d.m.Y') ?>
			</p>
		</div>
		<div class="uk-width-medium-1-6">
			<p class="meta">
				<?php if ($model->views > 0): ?>
					<?=Yii::t('forum','Views')?>: <?=$model->views?><br>				
				<?php endif ?>
				<?php if ($postCount): ?>
					<?=Yii::t('forum','Answers')?>: <?=$postCount?>
				<?php endif ?>
			</p>
		</div>
		<div class="uk-width-medium-1-6">
			<?php if ($model->lastPost !== null): ?>
				<?= Html::a(!empty($model->lastPost->user->name)?$model->lastPost->user->name:Yii::t('forum','Deleted user'),!empty($model->lastPost->user->url)?$model->lastPost->user->url:'#',['data'=>['pjax'=>0]]); ?><br>
				<?=Yii::$app->formatter->asRelativeTime($model->lastPost->created_at)?>
				<?= Html::a(null, $model->getUrl(['#'=>'post-'.$model->lastPost->id]),['class'=>'uk-icon-angle-double-right','data'=>['pjax'=>0]]); ?>
			<?php else: ?>
				<?= Html::a(' '.Yii::t('forum','Reply'), $model->getUrl(['#'=>'reply']),['class'=>'uk-icon-angle-double-right','data'=>['pjax'=>0]]); ?>
			<?php endif ?>
		</div>
	</div>
</div>