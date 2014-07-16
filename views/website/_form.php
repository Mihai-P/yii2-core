<?php

use yii\helpers\Html;
use theme\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var core\models\Website $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="website-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'host')->textInput(['maxlength' => 255]) ?>

<?php
	if($model->template) {
		echo $this->context->renderPartial($model->template, ['model' => $model, 'form' => $form]);
	} 
?>  

    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
