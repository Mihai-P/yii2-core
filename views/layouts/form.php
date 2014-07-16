<?php
use yii\helpers\Html;
?>
<?php $this->beginContent('@core/views/layouts/main.php'); ?>
<?php
	$flashes = Yii::$app->getSession()->getAllFlashes();
	if(count($flashes)) {
		foreach($flashes as $type => $message) {
			echo '<div class="bg-'.$type.' has-padding widget-inner">'.$message.'</div>';
		}
		Yii::$app->getSession()->removeAllFlashes();
	}
?>
	<div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title"><?= Html::encode($this->title) ?></h6></div>
        <div class="panel-body">
        	<?= $content ?>
        </div>
    </div>
<?php $this->endContent();