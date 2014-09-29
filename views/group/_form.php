<?php

use yii\helpers\Html;
use theme\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\AuthItem;

/**
 * @var yii\web\View $this
 * @var core\models\Group $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

<?php
	$items = AuthItem::find()->where("type < 2")->all();
	foreach($items as $item) {
		$data = unserialize($item->data);
		$checkbox_array[$data['module']][$data['controller']][$item->name] = ucfirst(substr($item->name, 0, strpos($item->name, '::')));
	}
	array_shift($checkbox_array);
	if(count($checkbox_array)) {
		$counter = 0; 
		foreach($checkbox_array as $module_name => $module_checkboxes) {
			echo '<h1>'.$module_name.'</h1>';
			foreach($module_checkboxes as $key => $controller_checkboxes) {
				echo '
					<div class="form-group field-group-privileges">
						<div class="col-sm-2"><label class="control-label" for="group-'.$key.'">'.$key.'</label></div>
						<div class="col-sm-10">' . Html::checkboxList('Group[privileges]', $model->privileges, $controller_checkboxes, ['class' => 'inline', 'itemOptions' => ['class' => 'styled']]) . '</div>
					</div>';
				$counter++;
			}
		}
	}
?>	

    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
