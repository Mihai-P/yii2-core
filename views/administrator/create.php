<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var core\models\Administrator $model
 */

$this->title = 'Create Administrator';
$this->params['breadcrumbs'][] = ['label' => 'Administrators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrator-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
