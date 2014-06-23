<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
        'fieldConfig' => [
            'template' => "<div class=\"col-sm-4\">{label}</div>\n<div class=\"col-sm-6\">{input}</div>",
        ]
    ]); ?>
        <?= $form->field($model, 'id') ?>
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>
        <span class="pull-right" style="text-align: right">
            <?= $form->field($model, 'status', array('template' => "{input}"))->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted', ], ['prompt' => '', 'placeholder' => 'Filter by Status', 'data-default' => 'active']) ?>
        </span>
<!-- The drop down menu -->
        <ul class="advance-search nav pull-right">
          <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>
            <div class="dropdown-menu pull-right form-horizontal" style="padding: 15px; width: 600px; background: #4E5659;">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'Group_id')->dropDownList([ '1' => 'Administrators'], ['prompt' => '', 'data-default' => '0']) ?>
                    </div>
                    <div class="col-sm-6"> 
                        <?= $form->field($model, 'id') ?>
                    </div>
                </div>            
            </div>
          </li>
        </ul>        
    </div>
    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'last_visit_time') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'firstname') ?>

    <?php // echo $form->field($model, 'lastname') ?>

    <?php // echo $form->field($model, 'picture') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'company') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'Postcode_id') ?>

    <?php // echo $form->field($model, 'Administrator_id') ?>

    <?php // echo $form->field($model, 'Contact_id') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'internal_comments') ?>

    <?php // echo $form->field($model, 'break_from') ?>

    <?php // echo $form->field($model, 'break_to') ?>

    <?php // echo $form->field($model, 'dob_date') ?>

    <?php // echo $form->field($model, 'ignore_activity') ?>

    <?php // echo $form->field($model, 'sms_subscription') ?>

    <?php // echo $form->field($model, 'email_subscription') ?>

    <?php // echo $form->field($model, 'validation_key') ?>

    <?php // echo $form->field($model, 'login_attempts') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'create_by') ?>
    <?php ActiveForm::end(); ?>

</div>
