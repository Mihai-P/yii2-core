<?php

use yii\helpers\Html;
use theme\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\PageTemplate;

/**
 * @var yii\web\View $this
 * @var core\models\Page $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'PageTemplate_id')->dropDownList(ArrayHelper::map(PageTemplate::find()->asArray()->all(), 'id', 'name'), ['prompt' => '', 'class' => 'select2']) ?>

    <?= $form->field($model, 'h1')->textInput(['maxlength' => 255]) ?>
<?php
	if($model->template) {
		echo $this->context->renderPartial('@app/views/page/' . $model->template, ['model' => $model, 'form' => $form]);
	} else {
		echo $this->context->renderPartial('_simple', ['model' => $model, 'form' => $form]);
	}
?>
    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
