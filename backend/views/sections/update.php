<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model worstinme\forum\backend\models\Sections */

$this->title = Yii::t('forum', 'Update {modelClass}: ', [
    'modelClass' => 'Sections',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('forum', 'Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('forum', 'Update');
?>
<div class="sections-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
