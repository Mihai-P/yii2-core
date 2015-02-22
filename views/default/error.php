<?php
use yii\helpers\Html;

/* @var $exception \yii\web\HttpException|\Exception */
/* @var $handler \yii\web\ErrorHandler */
?>
<div class="error-wrapper text-center">
<?php /*    <h1><?= Html::encode($code) ?></h1> */ ?>
    <h5><?= Html::encode($message) ?></h5>

    <!-- Error content -->
    <div class="error-content">
        <div class="row">
            <div class="col-md-12">
                <?= Html::a('Back to dashboard', '/', ['class' => "btn btn-danger btn-block"]);?>
            </div>
        </div>
    </div>
    <!-- /error content -->

</div>