<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model worstinme\forum\backend\models\Forums */

$this->title = Yii::t('forum', 'Update {modelClass}: ', [
    'modelClass' => 'Forums',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('forum', 'Forums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('forum', 'Update');
?>
<div class="forums-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
                'sections'=> $sections,
    ]) ?>

</div>
