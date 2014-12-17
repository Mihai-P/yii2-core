<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var core\models\Bookmark $model
 */

$this->title = 'Update Bookmark: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bookmarks', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bookmark-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
