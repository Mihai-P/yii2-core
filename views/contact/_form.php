<?php

use yii\helpers\Html;
use core\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Group;
use core\models\Administrator;
use core\models\Contact;

/**
 * @var yii\web\View $this
 * @var core\models\Contact $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Group_id')->dropDownList(ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'name'), ['prompt' => '', 'class' => 'select-full']) ?>

    <?= $form->field($model, 'is_admin')->textInput() ?>

    <?//= $form->field($model, 'Postcode_id')->dropDownList(ArrayHelper::map(Postcode::find()->asArray()->all(), 'id', 'name'), ['prompt' => '', 'class' => 'select-full']) ?>

    <?//= $form->field($model, 'Administrator_id')->dropDownList(ArrayHelper::map(Administrator::find()->asArray()->all(), 'id', 'name'), ['prompt' => '', 'class' => 'select-full']) ?>

    <?= $form->field($model, 'Contact_id')->dropDownList(ArrayHelper::map(Contact::find()->asArray()->all(), 'id', 'name'), ['prompt' => '', 'class' => 'select-full']) ?>

    <?= $form->field($model, 'login_attempts')->textInput() ?>

    <?= $form->field($model, 'last_visit_time')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'break_from')->textInput() ?>

    <?= $form->field($model, 'break_to')->textInput() ?>

    <?= $form->field($model, 'dob_date')->field(yii\jui\DatePicker::classname(), ['dateFormat' => 'yy-mm-dd',]) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'internal_comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ignore_activity')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'sms_subscription')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'email_subscription')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'picture')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'validation_key')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => 32]) ?>

    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
