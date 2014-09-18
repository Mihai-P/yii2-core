<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var core\models\AdministratorSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="administrator-search form-search">

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
            <?=  Html::resetButton('Reset', ['class' => 'btn btn-link reset-search']) ?>
        </div>
        <span class="pull-right" style="text-align: right">
            <?=  $form->field($model, 'status', array('template' => "{input}"))->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive'], ['prompt' => 'Filter by Status', 'placeholder' => 'Filter by Status', 'data-default' => 'active']) ?>
        </span>
    <?php ActiveForm::end(); ?>
</div>