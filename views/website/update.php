<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var core\models\Website $model
 */

$this->title = 'Update Website: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="website-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
