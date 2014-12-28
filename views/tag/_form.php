<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Tag;


/**
 * @var yii\web\View $this
 * @var core\models\Tag $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map(Tag::find()->select('type')->distinct()->asArray()->orderby('type')->all(), 'type', 'type'), ['prompt' => '', 'class' => 'select2']) ?>

    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
