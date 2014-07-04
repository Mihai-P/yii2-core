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
            <div class="navbar-header">
                <div class="hidden-lg pull-right">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-right">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
                        <span class="sr-only">Toggle sidebar</span>
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <ul class="nav navbar-nav navbar-left-custom">
                    <li class="user dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="http://placehold.it/500" alt="">
                            <span>Eugene Kopyov</span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                            <li><a href="#"><i class="fa fa-tasks"></i> Tasks</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                            <li><a href="#"><i class="fa fa-mail-forward"></i> Logout</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-icon sidebar-toggle"><i class="fa fa-bars"></i></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav navbar-right collapse" id="navbar-right">
                <li>
                    <a href="#">
                        <i class="fa fa-rotate-right"></i>
                        <span>Updates</span>
                        <strong class="label label-danger">15</strong>
                    </a>
                </li>

                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-comments"></i>
                        <span>Messages</span>
                        <strong class="label label-danger">7</strong>
                    </a>
                    <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                            <li><a href="#"><i class="fa fa-tasks"></i> Tasks</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                            <li><a href="#"><i class="fa fa-mail-forward"></i> Logout</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-tasks"></i>
                        <span>Notifications</span>
                    </a>
                </li>
            </ul>
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
