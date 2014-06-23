<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var core\models\Contact $model
 */

$this->title = 'Update Contact: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contact-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
