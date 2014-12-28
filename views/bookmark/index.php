<?php

use yii\helpers\Html;
use theme\widgets\GridView;
use theme\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var core\models\BookmarkSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Bookmarks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bookmark-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['options' => ['id'=>'main-pjax']]); ?>
    <?= GridView::widget([
        'id' => 'main-grid',
        'dataProvider' => $dataProvider,
        'buttons' => $this->context->bulkButtons(),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'theme\widgets\IdColumn'],
            ['class' => 'theme\widgets\NameColumn', 'hasView' => $this->context->hasView],
            // 'id',
            // 'name',
            // 'url:url',
            // 'reminder',
            // 'description:ntext',
            // 'order',
            // 'status',
            // 'update_time',
            // 'update_by',
            // 'create_time',
            // 'create_by',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'reminder',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->reminder ? Yii::$app->formatter->asDateTime($model->reminder, 'medium') : '-' ;
                },
            ],
            ['class' => 'theme\widgets\StatusColumn'],
            ['class' => 'theme\widgets\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
