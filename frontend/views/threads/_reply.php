<?php

use yii\helpers\Html;
use worstinme\uikit\ActiveForm;

?>

<?= worstinme\uikit\Alert::widget() ?>

<div class="thread-reply">
    <?php $form = ActiveForm::begin(['layout'=>'stacked','field_width'=>'large','options'=>['data'=>['pjax'=>true]]]); ?>

    <?=$form->field($model, 'content')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => Yii::$app->language,
            'minHeight' => 100,
            'buttons'=>['bold', 'italic', 'underline', 'deleted', '|','lists', 'image'],
        ]
    ])->label(false)?>

    <?= Html::submitButton(Yii::t('forum', 'REPLY_TO_THREAD'), ['class' => 'uk-button uk-button-success']) ?>

    <?php ActiveForm::end(); ?>
</div>