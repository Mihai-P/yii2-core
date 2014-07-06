<?php
use yii\helpers\Html;
use yii\helpers\Url;

$allButtons = $this->context->allButtons();
?>
<?php $this->beginContent('@core/views/layouts/main.php'); ?>
	<div class="panel panel-default">
        <div class="panel-heading">
        	<h6 class="panel-title"><?= Html::encode($this->title) ?></h6>
        	<?= Html::a('Add new', ['create'], ['class' => 'pull-right btn btn-xs btn-success']) ?>
<?php       if(count($allButtons)) { ?>
			<div class="dropdown pull-right">
                <a href="#" class="dropdown-toggle btn btn-link btn-icon" data-toggle="dropdown">
                    <i class="fa fa-cogs"></i>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" style="display: none;">
<?php       foreach($allButtons as $button) { ?>
                    <li><?= Html::a($button['text'], $button['url'], $button['options']);?></li>
<?php       } ?>
                </ul>
            </div>
<?php       } ?>
            <div class="col-sm-1 pull-right pagination">
            	Show: 
                <?= Html::dropDownList('pagination', Yii::$app->session->get($this->context->MainModel.'Pagination'), ['10' => '10 per page', '25' => '25 per page', '50' => '50 per page', '100' => '100 per page'], ['class' => "form-control input-sm pagination", 'data-change'=> Url::toRoute('pagination')]) ?>
            </div>
        </div>
        <div class="table-responsive">
        	<?= $content ?>
        </div>
    </div>
<?php $this->endContent();