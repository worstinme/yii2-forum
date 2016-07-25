<?php

use yii\helpers\Html;
use worstinme\uikit\ActiveForm;

?>

<?= worstinme\uikit\Alert::widget(['type'=>'comment']) ?>

<div class="thread-reply">
    <?php $form = ActiveForm::begin(['layout'=>'stacked','field_width'=>'large','options'=>['data'=>['pjax'=>true]]]); ?>

    <?=$form->field($model, 'content')->widget(\worstinme\jodit\Editor::className(), [
        'settings' => [
            'height'=>'120px',
            'enableDragAndDropFileToEditor'=>true,
            'uploader'=>[
                'url'=>\yii\helpers\Url::to(['upload-image','lang'=>$this->context->lang]),
                'data'=> [
                    '_csrf'=> Yii::$app->request->csrfToken,
                ],
            ],
            'buttons'=>[
                'bold', 'italic', 'underline', '|', 'ul', 'ol', '|', 'image',
            ],

        ],
        'options'=>['placeholder'=>Yii::t('forum','Type your message here')],
    ])->label(false);?>

    <div class="uk-form-row">
        <?= Html::submitButton(Yii::t('forum', 'Send message'), ['class' => 'uk-button uk-button-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>