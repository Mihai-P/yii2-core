<?php

use yii\helpers\Html;
use theme\widgets\GridView;
use theme\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var core\models\MenuSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['options' => ['id'=>'main-pjax']]); ?>
    <?= GridView::widget([
        'id' => 'main-grid',
        'dataProvider' => $dataProvider,
        'buttons' => $this->context->bulkButtons(),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'theme\widgets\CheckboxColumn'],
            [
                'class' => 'theme\widgets\IdColumn',
                'enableSorting' => false,
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'menuname',
                'header' => 'Name',
                'format'=>'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return "<h".($model->level+3).">" . str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $model->level-1) . ($model->level>1 ? '↳' : '') . $model->name . "</h".($model->level+3).">";
                },
            ],            
            'url',
            // 'name',
            // 'Menu_id',
            // 'order',
            // 'status',
            // 'update_time',
            // 'update_by',
            // 'create_time',
            // 'create_by',
            [
                'class' => 'theme\widgets\StatusColumn',
                'enableSorting' => false,

            ],
            ['class' => 'theme\widgets\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
