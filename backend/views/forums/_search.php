<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model worstinme\forum\backend\models\ForumsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forums-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'section_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'metaTitle') ?>

    <?php // echo $form->field($model, 'metaDescription') ?>

    <?php // echo $form->field($model, 'metaKeywords') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('forum', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('forum', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
