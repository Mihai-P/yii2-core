<?php
use yii\helpers\Html;
use yii\helpers\Url;

$icon = '<i class="fa fa-bookmark"></i>';
switch ($model->typeIcon) {
    case 'reminder':
        $icon = '<i class="fa fa-clock-o"></i>';
        break;
    case 'passed-reminder':
        $icon = '<i class="fa fa-exclamation-triangle text-danger"></i>';
        break;
}
?>
<li>
    <?= Html::a($icon . $model->name, $model->url, ['class' => 'col-md-11', 'data-pjax' => "0"])?>
    <?= Html::a('<i class="fa fa-edit"></i>', '#add-bookmark', ['data-pjax' => '0', 'data-details' => Url::toRoute(['/core/bookmark/details', 'id' => $model->id]), 'data-pjax' => '0', 'class' => "edit-bookmark col-md-1", 'data-toggle' => "modal", 'data-pjax' => "0"])?>
</li>