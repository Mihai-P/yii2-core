<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Tag;

/**
 * @var yii\web\View $this
 * @var core\models\TagSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="tag-search form-search">

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
            <?= $form->field($model, 'type', ['template' => "{input}"])->dropDownList(ArrayHelper::map(Tag::find()->select('type')->distinct()->asArray()->orderby('type ASC')->all(), 'type', 'type'), ['prompt' => 'Filter by Type', 'placeholder' => 'Filter by Type', 'data-default' => '']) ?>
            <?= $form->field($model, 'status', ['template' => "{input}"])->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive'], ['prompt' => 'Filter by Status', 'placeholder' => 'Filter by Status', 'data-default' => 'active']) ?>
        </span>
    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php ActiveForm::end(); ?>
</div>