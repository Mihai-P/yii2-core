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
            <?=  $form->field($model, 'status', array('template' => "{input}"))->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive'], ['prompt' => 'Filter by Status', 'placeholder' => 'Filter by Status', 'data-default' => 'active']) ?>
        </span>
    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'Group_id') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'type') ?>

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