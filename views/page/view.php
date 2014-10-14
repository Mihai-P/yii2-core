<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use theme\widgets\Seo\SeoWidget;
/**
 * @var yii\web\View $this
 * @var core\models\Page $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><?= Html::encode($this->title) ?></h6>
                <?php
                    if(\Yii::$app->user->checkAccess('update::' . $this->context->getCompatibilityId()))
                        echo Html::a('Edit', ['update', 'id' => $model->id], ['class' => "pull-right btn btn-xs btn-primary"]);
                ?>
            </div>
            <div class="table-responsive">
                <div class="contact-view">
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => "<tr><th width='25%'>{label}</th><td width='75%'>{value}</td></tr>",
                        'attributes' => [
                            'name',
                            'url',
                            'pageTemplate.name',
                            'template',
                            'status',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?=SeoWidget::widget(['model' => $model, 'accessPriviledge' => $this->context->getCompatibilityId()])?>
    </div>
</div>