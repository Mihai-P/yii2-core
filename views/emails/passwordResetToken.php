<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['subject'] = "Password Reset Request";
$this->params['intro'] = "You have initiated a password reset request.";
?>
<?php $this->beginContent('@core/views/emails/email.php'); ?>
    To reset your password please <a href="<?= Yii::$app->getUrlManager()->createAbsoluteUrl(['/core/default/reset-password', 'token' => $user->password_reset_token])?>"> click here </a>
<?php $this->endContent();