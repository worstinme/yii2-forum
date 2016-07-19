<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$postCount = $model->getPosts()->count();

?>
<div class="thread-panel">
	<div class="uk-grid uk-grid-small">
		<div class="uk-width-medium-2-3">
			<h2><?php if ($model->flag): ?><i class="uk-icon-star"></i> <?php endif ?><?=$model->state==$model::STATE_DELETED?'<em>DELETED: </em>':''?><?= Html::a($model->name, $model->url,['data'=>['pjax'=>0]]); ?></h2>
			<p class="meta">
				<?=Yii::t('forum','Author')?> <?= Html::a($model->user->name, $model->user->url,['data'=>['pjax'=>0]]); ?>,
				<?=Yii::t('forum','Published')?> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
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
				<?= Html::a($model->lastPost->user->name,$model->lastPost->user->url); ?><br>
				<?=Yii::$app->formatter->asRelativeTime($model->lastPost->created_at)?>
				<?= Html::a(null, $model->getUrl(['#'=>'post-'.$model->lastPost->id]),['class'=>'uk-icon-angle-double-right']); ?>
			<?php else: ?>
				<?= Html::a(' '.Yii::t('forum','Reply'), $model->getUrl(['#'=>'reply']),['class'=>'uk-icon-angle-double-right']); ?>
			<?php endif ?>
		</div>
	</div>
</div>