<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model worstinme\forum\backend\models\Sections */

$this->title = Yii::t('forum', 'Create Sections');
$this->params['breadcrumbs'][] = ['label' => Yii::t('forum', 'Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sections-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
