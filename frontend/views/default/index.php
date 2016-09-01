<?php

use yii\helpers\Html;
use worstinme\uikit\Nav;

$this->title = Yii::t('forum', 'Forum');

\worstinme\uikit\assets\Accordion::register($this);

$this->params['breadcrumbs'][] = $this->title;

?>

<section class="forum">

	<div class="forum-sections uk-accrdion">
		
		<?php foreach ($sections as $section): ?>
		
			<h2 class="uk-accordion-title"><?php if ($section->state == $section::STATE_HIDDEN): ?><em>HIDDEN:</em> <?php endif ?><?=$section->name?></h2>

			<div class="forum-section-forums uk-accordion-content uk-active">
				<?php foreach ($section->forums as $forum): ?>
				<div class="forum">
					<div class="uk-grid item uk-grid-small uk-grid-match" data-uk-grid-margin>
	                    <div class="uk-width-1-1 uk-width-medium-3-5">
	                        <div class="uk-panel">
	                        	<h3><?php if ($forum->state == $forum::STATE_HIDDEN): ?><em>HIDDEN:</em> <?php endif ?><?= Html::a($forum->name, $forum->url); ?></h3> 
	                        	<p><?=$forum->description?></p>
	                        </div>
	                    </div>
	                    <div class="uk-width-1-1 uk-width-medium-2-5">
	                    	<div class="uk-panel uk-flex uk-flex-middle">
		                    	<ul class="last-threads">
		                    	<?php foreach ($forum->lastThreads as $thread): ?>
									<li>
										<?= Html::a($thread->name, $thread->url); ?>
									</li>
		                        <?php endforeach ?>
		                        </ul>
	                        </div>
	                    </div>
	                </div>
				</div>
				<?php endforeach ?>

				<?php if ($section->canEdit): ?>

					<?= Nav::widget([
			            'options'=>['class'=>'uk-subnav-line uk-margin-top post-header'],
			            'navClass'=>'uk-subnav',
            			'encodeLabels'=>false,
			            'items' => [ 
			                ['label' =>Yii::t('forum','Edit section'),'url' =>['/forum/default/section-create','lang'=>$lang,'id'=>$section->id]], 
			                ['label' =>Yii::t('forum','Create forum'),'url' =>['/forum/default/forum-create','section_id'=>$section->id,'lang'=>$lang]], 
			                ['label' =>Yii::t('forum','Activate section'),'url' =>['/forum/default/section-activate','lang'=>$lang,'id'=>$section->id],'linkOptions'=>['data'=>['method'=>'post','confirm'=>Yii::t('forum','Sure to delete?')]],'visible'=>$section->state == $section::STATE_HIDDEN],
			                ['label' =>Yii::t('forum','Delete section'),'url' =>['/forum/default/section-delete','lang'=>$lang,'id'=>$section->id],'linkOptions'=>['data'=>['method'=>'post','confirm'=>Yii::t('forum','Sure to delete?')]],'visible'=>$section->state == $section::STATE_HIDDEN],
			                ['label' =>Yii::t('forum','Hide section'),'url' =>['/forum/default/section-delete','lang'=>$lang,'id'=>$section->id],'linkOptions'=>['data'=>['method'=>'post','confirm'=>Yii::t('forum','Sure to delete?')]],'visible'=>$section->state == $section::STATE_ACTIVE],
			            ],
			        ]); ?> 
		                        		
		        <?php endif ?>

			</div>

		<?php endforeach ?>

	</div>

	<?php if (!Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('moder'))): ?>
    
        <?= Html::a(Yii::t('forum','Create section'), 
            ['/forum/default/section-create','lang'=>$lang], 
            ['class' => 'uk-button uk-button-small uk-button-success']); ?>

    <?php endif ?>


</section>

<?php  $script = <<<JS

	var accordion = UIkit.accordion(UIkit.$('.uk-accrdion'), {collapse:false, showfirst: false});
	accordion.find('[data-wrapper]').each(function () {
	   accordion.toggleItem(UIkit.$(this), false, false); // animated true and collapse false
	});

JS;

$this->registerJs($script,$this::POS_READY);