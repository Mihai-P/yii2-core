<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use core\models\Menu;
/**
 * @var yii\web\View $this
 * @var core\models\MenuSearch $model
 * @var yii\widgets\ActiveForm $form
 */


$menus = Menu::find()->addOrderBy('root')->addOrderBy('lft')->all();
?>
<div class="menu-search form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => "form-inline",
        ], 
        'enableClientValidation' => false,
        'validateOnSubmit' => false,
        'validateOnChange' => false,
        'fieldConfig' => [
            'template' => "<div class=\"col-sm-4\">{label}</div>\n<div class=\"col-sm-6\">{input}</div>",
        ]        
    ]); ?>
        <?= Html::activeTextInput($model, 'keyword', ['class'=>'form-control','autocomplete'=>'off','placeholder'=>'Keyword']); ?>
        <div class="form-group">
            <?=  Html::submitButton('Search', ['class' => 'btn btn-primary start-search']) ?>
            <!-- Advance search -->
<?php /* 
             <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Advance Search <span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-icons-right form-horizontal advanced-search" style="padding: 15px; width: 600px; display: none;">
                    <li>
                        <div class="row">
                            <div class="col-sm-12">
                                <?=  $form->field($model, 'Group_id')->dropDownList([ '1' => 'Administrators'], ['prompt' => '', 'data-default' => '0']) ?>
                            </div>
                            <div class="col-sm-12"> 
                                <?=  $form->field($model, 'id') ?>
                            </div>
                        </div>            
                    </li>
                </ul>
            </div>
*/?>
            <?=  Html::resetButton('Reset', ['class' => 'btn btn-link reset-search']) ?>
        </div>
        <span class="pull-right" style="text-align: right">
            <div class="form-group field-menusearch-menu_id">
                <select id="menusearch-menu_id" class="form-control" name="MenuSearch[Menu_id]" placeholder="Filter by parent" data-default="">
                    <option value="">Filter by parent</option>
                    <option value="-1" <?= ($model->Menu_id == -1 ? 'SELECTED' : '')?>>MAIN MENUS</option>

<?php
foreach ($menus as $n => $menu)
{
    if($menu->lft+1 != $menu->rgt)
        echo '<option value="'.$menu->id.'" '.($model->Menu_id==$menu->id ? 'SELECTED' : '').'>'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $menu->level-1) . '↳' . $menu->name.'</option>';
}
?>                
                </select>
            </div>
            <?=  $form->field($model, 'status', array('template' => "{input}"))->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive'], ['prompt' => 'Filter by Status', 'placeholder' => 'Filter by Status', 'data-default' => 'active']) ?>
        </span>
    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'Menu_id') ?>

    <?php // echo $form->field($model, 'root') ?>

    <?php // echo $form->field($model, 'lft') ?>

    <?php // echo $form->field($model, 'rgt') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'h1') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php ActiveForm::end(); ?>
</div>