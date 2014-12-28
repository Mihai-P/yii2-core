<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "theme\\widgets\\GridView" : "yii\\widgets\\ListView" ?>;
use theme\widgets\Pjax;

/**
 * @var yii\web\View $this
<?= !empty($generator->searchModelClass) ? " * @var " . ltrim($generator->searchModelClass, '\\') . " \$searchModel\n" : '' ?>
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>
<?= "    <?php Pjax::begin(['options' => ['id'=>'main-pjax']]); ?>\n"; ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'id' => 'main-grid',
        'dataProvider' => $dataProvider,
        'buttons' => $this->context->bulkButtons(),
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'theme\widgets\IdColumn'],
            ['class' => 'theme\widgets\NameColumn', 'hasView' => $this->context->hasView],
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            // '" . $name . "',\n";
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
            ['class' => 'theme\widgets\StatusColumn'],
            ['class' => 'theme\widgets\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
<?= "    <?php Pjax::end(); ?>\n"; ?>
</div>
