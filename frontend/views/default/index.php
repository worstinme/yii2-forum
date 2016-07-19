<?php

use yii\helpers\Html;

$this->title = Yii::t('forum','Форум');

\worstinme\uikit\assets\Accordion::register($this);

$this->params['breadcrumbs'][] = $this->title;

?>

<section class="forum">

	<div class="forum-sections uk-accrdion">
		
		<?php foreach ($sections as $section): ?>
		
			<h2 class="uk-accordion-title"><?=$section->name?></h2>
			<div class="forum-section-forums uk-accordion-content uk-active">
				<?php foreach ($section->forums as $forum): ?>
				<div class="forum">
					<div class="uk-grid item uk-grid-small uk-grid-match" data-uk-grid-margin>
	                    <div class="uk-width-1-1 uk-width-medium-3-5">
	                        <div class="uk-panel">
	                        	<h3><?= Html::a($forum->name, $forum->url); ?></h3>
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
			</div>

		<?php endforeach ?>

	</div>

</section>

<?php  $script = <<<JS

	var accordion = UIkit.accordion(UIkit.$('.uk-accrdion'), {collapse:false, showfirst: false});
	accordion.find('[data-wrapper]').each(function () {
	   accordion.toggleItem(UIkit.$(this), false, false); // animated true and collapse false
	});

JS;

$this->registerJs($script,$this::POS_READY);