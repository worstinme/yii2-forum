<?php

use yii\helpers\Html;
use worstinme\uikit\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('forum', 'Sections');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sections-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forum', 'Create Sections'), ['create'], ['class' => 'uk-button uk-button-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class'=>'items'],
        'layout'=>'{items}{pager}',
        'columns' => [
            'name',
            'alias',
            'lang',
            'description:ntext',
            'state',
            'sort',
            ['class' => 'worstinme\uikit\widgets\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
