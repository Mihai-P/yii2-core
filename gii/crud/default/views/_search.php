<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->searchModelClass, '\\') ?> $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search form-search">

    <?= "<?php " ?>$form = ActiveForm::begin([
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
        <?= "<?= " ?>Html::activeTextInput($model, 'keyword', ['class'=>'form-control','autocomplete'=>'off','placeholder'=>'Keyword']); ?>
        <div class="form-group">
            <!-- Advance search -->
<?= "<?php /* \r\n" ?>
             <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Advance Search <span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-icons-right form-horizontal advanced-search" style="padding: 15px; width: 600px; display: none;">
                    <li>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= "<?= " ?> $form->field($model, 'Group_id')->dropDownList([ '1' => 'Administrators'], ['prompt' => '', 'data-default' => '0']) ?>
                            </div>
                            <div class="col-sm-12"> 
                                <?= "<?= " ?> $form->field($model, 'id') ?>
                            </div>
                        </div>            
                    </li>
                </ul>
            </div>
<?= "*/?>\r\n" ?>
            <?= "<?= " ?> Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary start-search']) ?>
            <?= "<?= " ?> Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-link reset-search']) ?>
        </div>
        <span class="pull-right" style="text-align: right">
            <?= "<?= " ?> $form->field($model, 'status', array('template' => "{input}"))->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive'], ['prompt' => 'Filter by Status', 'placeholder' => 'Filter by Status', 'data-default' => 'active']) ?>
        </span>
<?php
foreach ($generator->getColumnNames() as $attribute) {
    echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
}
?>
    <?= "<?php " ?>ActiveForm::end(); ?>
</div>