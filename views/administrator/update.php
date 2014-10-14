<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var core\models\Administrator $model
 */

$this->title = 'Update Administrator: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Administrators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="administrator-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
