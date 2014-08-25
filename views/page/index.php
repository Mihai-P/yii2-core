<?php

use yii\helpers\Html;
use theme\widgets\GridView;
use theme\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var core\models\PageSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['options' => ['id'=>'main-pjax']]); ?>
    <?= GridView::widget([
        'id' => 'main-grid',
        'dataProvider' => $dataProvider,
        'buttons' => $this->context->bulkButtons(),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'theme\widgets\CheckboxColumn'],
            ['class' => 'theme\widgets\IdColumn'],
            ['class' => 'theme\widgets\NameColumn'],
            // 'id',
            // 'name',
            'url',
            // 'template',
            // 'content:ntext',
            // 'status',
            // 'update_time',
            // 'update_by',
            // 'create_time',
            // 'create_by',
            ['class' => 'theme\widgets\StatusColumn'],
            ['class' => 'theme\widgets\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
