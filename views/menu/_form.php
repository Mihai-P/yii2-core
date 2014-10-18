<?php

use yii\helpers\Html;
use theme\widgets\ActiveForm;
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
    
    <div class="form-group field-menu-menu_id <?= ($model->hasErrors('Menu_id') ? "has-error" : "") ?>">
        <div class="col-sm-2"><label class="control-label" for="menu-menu_id">Parent</label></div>
        <div class="col-sm-10">
            <select id="menu-menu_id" class="select2" name="Menu[Menu_id]">
            <option value="">Main Menu</option>
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

    <?= $form->field($model, 'target')->dropDownList(Menu::targetOptions()) ?>

    <?= $form->field($model, 'rel')->dropDownList(Menu::relOptions()) ?>

    <?= $form->field($model, 'responsive')->dropDownList(Menu::responsiveOptions()) ?>

    <h2 id="responsive-utilities-classes">Available classes</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped responsive-utilities">
            <thead>
            <tr>
                <th></th>
                <th>
                    Extra small devices
                    <small>Phones (&lt;768px)</small>
                </th>
                <th>
                    Small devices
                    <small>Tablets (≥768px)</small>
                </th>
                <th>
                    Medium devices
                    <small>Desktops (≥992px)</small>
                </th>
                <th>
                    Large devices
                    <small>Desktops (≥1200px)</small>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>Visible only on small phones</th>
                <td class="is-visible">Visible</td>
                <td class="is-hidden">Hidden</td>
                <td class="is-hidden">Hidden</td>
                <td class="is-hidden">Hidden</td>
            </tr>
            <tr>
                <th>Visible only on small phones<br/>and small tablets</th>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
                <td class="is-hidden">Hidden</td>
                <td class="is-hidden">Hidden</td>
            </tr>
            <tr>
                <th>Visible only on small phones<br/>and small tablets and medium desktops</th>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
                <td class="is-hidden">Hidden</td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <th>Always visible</th>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <th>Hidden on small phones</th>
                <td class="is-hidden">Hidden</td>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
            </tr>
            <tr>
                <th>Hidden on small phones<br/>and small tablets</th>
                <td class="is-hidden">Hidden</td>
                <td class="is-hidden">Hidden</td>
                <td class="is-visible">Visible</td>
                <td class="is-visible">Visible</td>
            </tr>
            <tr>
                <th>Hidden on small phones<br/>and small tablets and medium desktops</th>
                <td class="is-hidden">Hidden</td>
                <td class="is-hidden">Hidden</td>
                <td class="is-hidden">Hidden</td>
                <td class="is-visible">Visible</td>
            </tr>
            </tbody>
        </table>
    </div>
    <br/>
    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>