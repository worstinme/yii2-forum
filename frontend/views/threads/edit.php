<?php

use yii\helpers\Html;
use worstinme\uikit\ActiveForm;

$this->title = Yii::t('forum','Создание новой темы');

\worstinme\uikit\assets\Accordion::register($this);

\worstinme\jodit\Asset::register($this);

$this->params['breadcrumbs'][] = ['label'=>Yii::t('forum','Форум'), 'url'=> ['/forum/default/index','lang'=>$lang]];
$this->params['breadcrumbs'][] = $this->title;

?>

<section class="forum">

    <div class="thread-form">

        <?php $form = ActiveForm::begin(['layout'=>'stacked','field_width'=>'large']); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?=$form->field($model, 'content')->widget(\worstinme\jodit\Editor::className(), [
            'settings' => [
                'height'=>'250px',
                'enableDragAndDropFileToEditor'=>true,
                'uploader'=>[
                    'url'=>\yii\helpers\Url::to(['/site/upload-image','lang'=>Yii::$app->language]),
                ],
                'filebrowser'=>[
                    'ajax'=>[
                        'url'=>\yii\helpers\Url::to(['/site/file-browser','lang'=>Yii::$app->language]),
                        'data'=> [
                            '_csrf'=> Yii::$app->request->csrfToken,
                        ],
                    ]
                ],
                'buttons'=>[
                    'bold', 'italic', 'underline', '|', 'ul', 'ol', '|', 'image', '|', 'hr',
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