<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var core\models\Website $model
 */

$this->title = 'Create Website';
$this->params['breadcrumbs'][] = ['label' => 'Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="website-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
