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
?>


<!-- Login wrapper -->
<div class="login-wrapper">
	<?php $form = ActiveForm::begin([
		'id' => 'reset-password-form',
		'options' => [
			'role' => 'form',
			'class' => 'small-form',
		],
        'enableClientValidation' => false,
        'validateOnSubmit' => false,
        'validateOnChange' => false,		
		'fieldConfig' => [
			'template' => "{input}{error}",
		],
	]); ?>
        <div class="panel panel-default">
            <div class="panel-heading"><h6 class="panel-title"><i class="fa fa-user"></i> Reset Password</h6></div>
            <div class="panel-body">
            	<p>Please enter your desired password below.</p>
				<?= $form->field($model, 'password', ['template' => '<div class="form-group has-feedback">{label}{input}{hint}{error}<i class="fa fa-lock form-control-feedback"></i></div>'])->passwordInput(['placeholder' => $model->getAttributeLabel('password')]); ?>
				<?= $form->field($model, 'password_repeat', ['template' => '<div class="form-group has-feedback">{label}{input}{hint}{error}<i class="fa fa-lock form-control-feedback"></i></div>'])->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')]); ?>

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
