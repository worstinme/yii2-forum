<?php

use yii\helpers\Html;
use worstinme\uikit\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel worstinme\forum\backend\models\ForumsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('forum', 'Forums');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forums-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('forum', 'Create Forums'), ['create'], ['class' => 'uk-button uk-button-success']) ?>
    </p>
    
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class'=>'items'],
        'filterModel' => $searchModel,
        'layout'=>'{items}{pager}',
        'columns' => [
            'name',
            'section.name',
            'alias',
            'lang',
            'state',
            ['class' => 'worstinme\uikit\widgets\ActionColumn'],
        ],
    ]); ?>

<?php Pjax::end(); ?></div>
