<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var auth\models\User $model
 */

$this->title = Yii::t('core.user', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core.user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
