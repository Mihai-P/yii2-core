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
            <div class="col-md-3">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
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
    <div class="page-container container-fluid">
        <!-- Sidebar -->
        <div class="sidebar collapse">
            <ul class="navigation">
<?php        
    function change_url($url) {
        return strtolower(str_replace(array('/admin', '/-'), array('', '/'), preg_replace("([A-Z])", "-$0", $url)));
    }
    $menus = AdminMenu::find()->with('adminMenus')->where('AdminMenu_id IS NULL')->active()->orderBy('order ASC')->all();
    foreach($menus as $menu) {
        $submenus = array();
        foreach($menu->adminMenus as $submenu)
            //if($submenu->checkAccess() || 1==1)
                $submenus[] = '<li><a href="'.change_url($submenu->url).'">'.$submenu->name . '</a></li>';

        //if($menu->checkAccess() || 1==1) {
        if(count($submenus)) {
            echo '
                <li>
                    <a href="#" class="expand level-closed"><i class="fa fa-align-justify"></i> '.$menu->name . '</a>
                    <ul style="display: none;">'.implode('', $submenus).'</ul>
                </li>';
        } else {
            echo '<li><a href="'.change_url($menu->url).'"><i class="fa fa-bar-chart-o"></i> '.$menu->name.'</a></li>';
        }
    }
?>            
                <!--li class="active"><a href="index.html"><i class="fa fa-laptop"></i> Dashboard</a></li>
                <li><a href="charts.html"><i class="fa fa-bar-chart-o"></i> Graphs and charts</a></li>
                <li>
                    <a href="#" class="expand level-closed"><i class="fa fa-align-justify"></i> Form components</a>
                    <ul style="display: none;">
                        <li><a href="form_components.html">Form components</a></li>
                        <li><a href="form_validation.html">Form validation</a></li>
                        <li><a href="wysiwyg.html">WYSIWYG editor</a></li>
                        <li><a href="form_layouts.html">Form layouts</a></li>
                        <li><a href="form_grid.html">Inputs grid</a></li>
                        <li><a href="file_uploader.html">Multiple file uploader</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="expand level-closed"><i class="fa fa-tasks"></i> Interface components</a>
                    <ul style="display: none;">
                        <li><a href="visuals.html">Visuals &amp; notifications</a></li>
                        <li><a href="navs.html">Navs &amp; navbars</a></li>
                        <li><a href="panel_options.html">Panels</a></li>
                        <li><a href="icons.html">Icons <span class="label label-danger">190</span></a></li>
                        <li><a href="buttons.html">Buttons</a></li>
                        <li><a href="content_grid.html">Content grid</a></li>
                    </ul>
                </li>
                <li><a href="typography.html"><i class="fa fa-text-height"></i> Typography</a></li>
                <li><a href="gallery.html"><i class="fa fa-picture-o"></i> Gallery</a></li>
                <li>
                    <a href="#" class="expand level-closed"><i class="fa fa-table"></i> Tables</a>
                    <ul style="display: none;">
                        <li><a href="tables_static.html">Static tables</a></li>
                        <li><a href="tables_data.html">Data tables</a></li>
                        <li><a href="tables_custom.html">Custom tables</a></li>
                        <li><a href="tables_data_advanced.html">Advanced data tables</a></li>
                    </ul>
                </li>
                <li><a href="calendar.html"><i class="fa fa-calendar"></i> Calendar</a></li>
                <li><a href="#" class="expand level-closed"><i class="fa fa-warning"></i> Error pages <span class="label label-warning">6</span></a>
                    <ul style="display: none;">
                        <li><a href="403.html">403 page</a></li>
                        <li><a href="404.html">404 page</a></li>
                        <li><a href="405.html">405 page</a></li>
                        <li><a href="500.html">500 page</a></li>
                        <li><a href="503.html">503 page</a></li>
                        <li><a href="offline.html">Website is offline</a></li>
                    </ul>
                </li>
                <li><a href="#" class="expand level-closed"><i class="fa fa-copy"></i> Blank pages <span class="label label-warning">6</span></a>
                    <ul style="display: none;">
                        <li><a href="blank_fixed_navbar.html">Fixed navbar</a></li>
                        <li><a href="blank_static_navbar.html">Static navbar</a></li>
                        <li><a href="blank_collapsed_sidebar.html">Collapsed sidebar</a></li>
                        <li><a href="blank_full_width.html">Full width page</a></li>
                    </ul>
                </li-->
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
