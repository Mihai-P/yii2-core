<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use core\models\AdminMenu;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="full-width">
    <?php $this->beginBody() ?>
<!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
        </div>
    </div>

    <!-- Page container -->
    <div class="page-container container-fluid">
    
        <!-- Page content -->
        <div class="page-content">
        	<?= $content ?>
        </div>
        <!-- /page content -->

    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
