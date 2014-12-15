<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use core\models\AdminMenu;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use core\models\History;

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
<body>
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
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?= Yii::$app->user->getIdentity()->name?></span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                            <li><?= Html::a('<i class="fa fa-mail-forward"></i> Logout', ['/core/default/logout'])?></li>
                        </ul>
                    </li>

                    <li><a class="nav-icon sidebar-toggle"><i class="fa fa-bars"></i></a></li>
                </ul>
            </div>
            <div class="col-md-3 hidden-xs hidden-sm hidden-md">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>
            <ul class="nav navbar-nav navbar-right" id="navbar-right">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-warning"></i>
                        <span>Warnings</span>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                    <li>
                                        <a href="#">
                                            <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users warning"></i> 5 new members joined
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="ion ion-ios7-cart success"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="ion ion-ios7-person danger"></i> You changed your username
                                        </a>
                                    </li>
                                </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 43px; opacity: 0.4; display: none; border-radius: 0px; z-index: 99; right: 1px; height: 156.862745098039px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
<?php
                $history = History::find()->where('create_by = "'.Yii::$app->user->id.'"')->orderBy('create_time DESC')->groupBy('url')->limit(10)->all();
                if(count($history)) {
?>
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-comments"></i>
                        <span>History</span>
                        <strong class="label label-success"><?= count($history);?></strong>
                    </a>
                    <ul class="dropdown-menu">
<?php
                    foreach($history as $link) {
                        echo '<li>' . Html::a($link->name, $link->url) . '</li>';
                    }
?>
                    </ul>
                </li>
<?php                 
                }
?>
                <li>
                    <a href="/core/default/logout">
                        <i class="fa fa-mail-forward"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-container container-fluid">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul class="navigation">
<?php        
    $menus = AdminMenu::find()->with('adminMenus')->where('AdminMenu_id IS NULL')->active()->orderBy('order ASC')->all();
    foreach($menus as $menu) {
        $submenus = [];
        foreach($menu->adminMenus as $submenu)
            if(Yii::$app->user->checkAccess($submenu->ap))
                $submenus[] = '<li><a href="'.$submenu->url.'">'.($submenu->icon ? '<i class="fa '.$submenu->icon.'"></i> ' : '') . $submenu->name . '</a></li>';

        if(Yii::$app->user->checkAccess($menu->ap)) {
            if(count($submenus)) {
                echo '
                    <li>
                        <a href="#" class="expand level-closed">'.($menu->icon ? '<i class="fa '.$menu->icon.'"></i> ' : '<i class="fa fa-align-justify"></i>') . $menu->name . ' <i class="fa pull-right fa-align-justify"></i></a>
                        <ul style="display: none;">'.implode('', $submenus).'</ul>
                    </li>';
            } else {
                echo '<li><a href="'.$menu->url.'">'.($menu->icon ? '<i class="fa '.$menu->icon.'"></i> ' : '<i class="fa fa-align-justify"></i>') . $menu->name.'</a></li>';
            }
        }
    }
?>            
            </ul>
        </div>
        <!-- /sidebar -->

        <!-- Page content -->
        <div class="page-content" style="padding-top">
            <?= $content ?>
        </div>
    </div>
        

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
