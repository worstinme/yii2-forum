<?php

use yii\helpers\Html;

$this->title = $forum->title;

\worstinme\uikit\assets\Accordion::register($this);

$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum','Форум'), 'url'=> ['/forum/default/index','lang'=>$lang]];
$this->params['breadcrumbs'][] = $this->title;

?>


<?= Html::a(Yii::t('forum','Создать новую тему'), 
	['/forum/threads/new-thread','lang'=>$lang,'section'=>$forum->section->alias,'forum'=>$forum->alias], 
	['class' => 'uk-button uk-button-success']); ?>

<?php  $script = <<<JS

	
JS;

$this->registerJs($script,$this::POS_READY);