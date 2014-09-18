<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Tag;

/**
 * @var yii\web\View $this
 * @var core\models\ContactSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="form-search">

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
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary start-search']) ?>
            <!-- Advance search -->
            <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Advance Search <span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-icons-right form-horizontal advanced-search" style="padding: 15px; width: 700px;">
                    <li>
                        <div class="row">
                            <div class="col-sm-8">
                                <?= $form->field($model, 'create_time_from', [
                                    'template' => "<div class=\"col-sm-6\">{label}</div>\n<div class=\"col-sm-5\">{input}{error}{hint}</div>"
                                ])->widget(\theme\widgets\DatePicker::classname(), ['options' => ['class'=>'form-control'], 'clientOptions' => ['dateFormat' => 'M d, yy']]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, 'create_time_to', [
                                    'template' => "<div class=\"col-sm-2\">{label}</div>\n<div class=\"col-sm-10\">{input}{error}{hint}</div>"
                                ])->widget(\theme\widgets\DatePicker::classname(), ['options' => ['class'=>'form-control'], 'clientOptions' => ['dateFormat' => 'M d, yy']]) ?>
                            </div>
                        </div>

                        <div class="row buttons">
                            <div class="col-sm-6 pull-right"> 
                                <?=  Html::resetButton('Reset', ['class' => 'btn btn-link reset-search']) ?>
                                <?=  Html::submitButton('Search', ['class' => 'btn btn-primary start-search']) ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-link reset-search']) ?>
        </div>
        <span class="pull-right" style="text-align: right">
            <?= $form->field($model, 'tag', array('template' => "{input}"))->dropDownList(ArrayHelper::map(Tag::find()->asArray()->where('status <> "deleted" AND type="Contact"')->orderby('name ASC')->all(), 'id', 'name'), ['prompt' => 'Filter by Tag', 'placeholder' => 'Filter by Tag', 'data-default' => '']) ?>
            <?= $form->field($model, 'status', array('template' => "{input}"))->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted', ], ['prompt' => 'Filter by Status', 'placeholder' => 'Filter by Status', 'data-default' => 'active']) ?>
        </span>
    <?php ActiveForm::end(); ?>
</div>
