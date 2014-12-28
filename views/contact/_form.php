<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Group;
use core\models\Administrator;
use core\models\Contact;

/**
 * @var yii\web\View $this
 * @var core\models\Contact $model
 * @var yii\widgets\ActiveForm $form
 */
$model->tags = $model->getTags();
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'tags')->widget(\theme\widgets\InputTags::classname()) ?>

    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
