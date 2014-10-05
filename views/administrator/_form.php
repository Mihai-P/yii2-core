<?php

use yii\helpers\Html;
use theme\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Group;
use theme\widgets\InputFile;

/**
 * @var yii\web\View $this
 * @var core\models\Administrator $model
 * @var yii\widgets\ActiveForm $form
 */
if(!$model->hasErrors()) {
    $model->new_password = '';
    $model->new_password_repeat = '';
}
?>

<div class="administrator-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'validateOnSubmit' => false,
        'validateOnChange' => false,
    ]); ?>

    <?= $form->field($model, 'Group_id')->dropDownList(ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'name'), ['prompt' => '', 'class' => 'select2']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'new_password_repeat')->passwordInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'picture')->widget(InputFile::classname()) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 255]) ?>

    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
