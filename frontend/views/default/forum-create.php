<?php

use yii\helpers\Html;
use worstinme\uikit\ActiveForm;

$this->title = Yii::t('forum', 'Create Forum');
$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum', 'Forum'), 'url'=> ['/forum/default/index','lang'=>$lang]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forums-create">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="sections-form">

	    <?php $form = ActiveForm::begin(['layout'=>'horizontal','field_width'=>'large']); ?>

	    <?= $form->field($model, 'section_id')->dropDownList($sections, ['prompt' => Yii::t('forum','Раздел')]); ?>

	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'alias')->aliasInput('name', ['maxlength' => true]) ?>

	    <?= $form->field($model, 'lang')->dropDownList(Yii::$app->controller->module->languages); ?>

	    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

	    <?= $form->field($model, 'state')->checkbox(); ?>

	    <?= $form->field($model, 'sort')->textInput() ?>

	    <?= $form->field($model, 'metaTitle')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'metaDescription')->textarea(['rows' => 6]) ?>

	    <?= $form->field($model, 'metaKeywords')->textInput(['maxlength' => true]) ?>

	    <div class="uk-form-row">
	        <div class="uk-form-controls">
	            <?= Html::submitButton($model->isNewRecord ? Yii::t('forum', 'Create') : Yii::t('forum', 'Update'), ['class' => $model->isNewRecord ? 'uk-button uk-button-success' : 'uk-button uk-button-primary']) ?>
	        </div>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>
