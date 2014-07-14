<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var auth\models\LoginForm $model
 */
$this->title = \Yii::t('core.user', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- Login wrapper -->
<div class="login-wrapper">
<?php
	$flashes = Yii::$app->getSession()->getAllFlashes();
	if(count($flashes)) {
		foreach($flashes as $type => $message) {
			echo '<div class="bg-'.$type.' has-padding widget-inner">'.$message.'</div>';
		}
		Yii::$app->getSession()->removeAllFlashes();
	}
?>

	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'options' => ['role' => 'form'],
        'enableClientValidation' => false,
        'validateOnSubmit' => false,
        'validateOnChange' => false,		
		'fieldConfig' => [
			'template' => "{input}",
			//'labelOptions' => ['class' => 'col-lg-1 control-label'],
		],
	]); ?>
        <div class="panel panel-default">
            <div class="panel-heading"><h6 class="panel-title"><i class="fa fa-user"></i> Reset Password</h6></div>
            <div class="panel-body">
            	<p>Please enter your email address below and we will send you an email with further instructions.</p>
				<?= $form->field($model, 'email', ['options' => ['class' => 'form-group input-group input-group-lg'], 'template' => '<span class="input-group-addon"><i class=" glyphicon glyphicon-user"></i></span>{input}'])->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

				<div class="form-group">
					<div class="text-center">
						<?= Html::submitButton(\Yii::t('core.user', 'Reset'), ['class' => 'btn btn-primary btn-lg btn-block']) ?>
					</div>
				</div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>  
<!-- /login wrapper -->  


<div class="site-login center-block col-lg-3 col-md-4 col-sm-6" style="float:none;">


</div>
