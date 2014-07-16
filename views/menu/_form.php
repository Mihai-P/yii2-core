<?php

use yii\helpers\Html;
use theme\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Menu;

/**
 * @var yii\web\View $this
 * @var core\models\Menu $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="menu-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    
    <div class="form-group field-menu-menu_id required <?= ($model->hasErrors('Menu_id') ? "has-error" : "") ?>">
        <div class="col-sm-2"><label class="control-label" for="menu-menu_id">Parent</label></div>
        <div class="col-sm-10">
            <select id="menu-menu_id" class="select2" name="Menu[Menu_id]">
            <?php 
            	$menus = Menu::find()->where('status <> "deleted"')->addOrderBy('root')->addOrderBy('lft')->all();
            	foreach ($menus as $n => $menu) {
            	    echo '<option value="'.$menu->id.'" '.($model->Menu_id==$menu->id ? 'SELECTED' : '').'>'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $menu->level-1) . '↳' . $menu->name.'</option>';
            	}
            ?>
            </select>
        </div>
    </div>
    
    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'target')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'rel')->textInput(['maxlength' => 255]) ?>
    
    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>