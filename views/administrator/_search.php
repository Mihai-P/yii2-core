<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var core\models\AdministratorSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="administrator-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'Group_id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'is_admin') ?>

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

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
