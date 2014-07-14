<?php

use yii\helpers\Html;
use theme\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Group;

/**
 * @var yii\web\View $this
 * @var core\models\Administrator $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="administrator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Group_id')->dropDownList(ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'name'), ['prompt' => '', 'class' => 'select2']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'picture')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 255]) ?>

    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
