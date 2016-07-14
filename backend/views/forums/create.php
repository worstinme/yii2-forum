<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model worstinme\forum\backend\models\Forums */

$this->title = Yii::t('forum', 'Create Forums');
$this->params['breadcrumbs'][] = ['label' => Yii::t('forum', 'Forums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forums-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
                'sections'=> $sections,
    ]) ?>

</div>
