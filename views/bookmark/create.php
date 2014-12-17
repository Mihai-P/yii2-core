<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var core\models\Bookmark $model
 */

$this->title = 'Create Bookmark';
$this->params['breadcrumbs'][] = ['label' => 'Bookmarks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bookmark-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
