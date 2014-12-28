<?php
use yii\widgets\ListView;
use kartik\sortable\Sortable;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Order Menus';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider->pagination = false;
$query = $dataProvider->query;

$result = $query->asArray()->all();
foreach($result as $item) {
	switch($item['status']) {
		case "inactive":
			$label = '<span class="label label-warning pull-right">Inactive</span>';
			break;
		case "active":
			$label = '<span class="label label-success pull-right">Active</span>';
			break;
		default:
			$label = '<span class="label label-primary pull-right">'.$item['status'].'</span>';
	}

	$items[] = ['content'=>$item['name'] . Html::hiddenInput('Menu[]', $item['id']) . $label];
}

$form = ActiveForm::begin(['id' => 'sort-form']);

echo Sortable::widget([
	    'items'=>$items
	]);	
?>
    <div class="form-actions text-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>