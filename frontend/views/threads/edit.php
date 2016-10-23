<?php

use yii\helpers\Html;
use worstinme\uikit\ActiveForm;

$this->title = Yii::t('forum', 'Creating a new theme');

\worstinme\uikit\assets\Accordion::register($this);

\worstinme\jodit\Asset::register($this);

$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum', 'Forum'), 'url'=> ['/forum/default/index','lang'=>$lang]];
$this->params['breadcrumbs'][] = $this->title;


?>

<section class="forum">

    <div class="thread-form">

        <?php $form = ActiveForm::begin(['layout'=>'stacked','field_width'=>'large']); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php if(Yii::$app->controller->module->relatedModel): ?>

            <?php $relation = Yii::$app->controller->module->relatedModel; ?>

            <?= $form->field($model, 'related_id')->dropDownList($relation::forumRelationList(), ['prompt'=>Yii::t('forum','Select related item')]); ?>

        <?php endif ?>

        <?= $form->field($model, 'content')->widget(\worstinme\jodit\Editor::className(), [
            'settings' => [
                'enableDragAndDropFileToEditor'=>new \yii\web\JsExpression("true"),
                'uploader'=>[
                    'url'=>\yii\helpers\Url::to(['upload-image','lang'=>$this->context->lang]),
                    'data'=> [
                        '_csrf'=> Yii::$app->request->csrfToken,
                    ],
                ],
               'filebrowser'=>[
                    'ajax'=>[
                        'url'=>\yii\helpers\Url::to(['file-browser','lang'=>$this->context->lang]),
                        'data'=> [
                            '_csrf'=> Yii::$app->request->csrfToken,
                        ],
                    ],
                    'uploader' => [
                        'url'=>\yii\helpers\Url::to(['upload-image','lang'=>$this->context->lang]),
                        'data'=> [
                            '_csrf'=> Yii::$app->request->csrfToken,
                        ],
                    ],
                    'createNewFolder'=>false,
                    'deleteFolder'=>false,
                ], 
                'buttons'=>[
                    'bold', 'italic', 'underline', '|', 'ul', 'ol', '|', 'image', '|', 'hr', 
                ],
                'cleanHTML'=>[
                    'cleanOnPaste'=>new \yii\web\JsExpression("true"),
                ],

            ],
        ]);?>

        <div class="uk-form-row">
            <div class="uk-form-controls">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('forum', 'Create') : Yii::t('forum', 'Update'), ['class' => $model->isNewRecord ? 'uk-button uk-button-success' : 'uk-button uk-button-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</section>


<?php  $script = <<<JS

	
JS;

$this->registerJs($script,$this::POS_READY);