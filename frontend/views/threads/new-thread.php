<?php

use yii\helpers\Html;
use worstinme\uikit\ActiveForm;

$this->title = Yii::t('forum','Создание новой темы');

\worstinme\uikit\assets\Accordion::register($this);

$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum','Форум'), 'url'=> ['/forum/default/index','lang'=>$lang]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="thread-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal','field_width'=>'large']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="uk-form-row">
        <div class="uk-form-controls">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('forum', 'Create') : Yii::t('forum', 'Update'), ['class' => $model->isNewRecord ? 'uk-button uk-button-success' : 'uk-button uk-button-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php  $script = <<<JS

	
JS;

$this->registerJs($script,$this::POS_READY);