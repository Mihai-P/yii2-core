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
    if($model->isNewRecord && count(Yii::$app->getModule('core')->pageTemplates) > 1) {
        echo $form->field($model, 'template')->dropDownList(Yii::$app->getModule('core')->pageTemplates);
    } else {
        if(is_file($this->findViewFile("@app/views/page/" . $model->template))) {
            echo $this->context->renderPartial("@app/views/page/" . $model->template, ['model' => $model, 'form' => $form]);
        } elseif(is_file($this->findViewFile("@core/views/page/" . $model->template))) {
            echo $this->context->renderPartial("@core/views/page/" . $model->template, ['model' => $model, 'form' => $form]);
        }
	}
?>
    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
