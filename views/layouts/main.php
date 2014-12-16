<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use core\models\AdminMenu;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use core\models\History;
use core\models\Bookmark;
use theme\widgets\ActiveForm;
use theme\widgets\Pjax;
use yii\helpers\Url;

use kartik\datetime\DateTimePickerAsset;
use kartik\datetime\DateTimePicker;
use yii\widgets\ActiveFormAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
DateTimePickerAsset::register($this);
ActiveFormAsset::register($this);
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
                            <span><?= Yii::$app->user->getIdentity()->firstname?></span>
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
                <!--li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-warning"></i>
                        <span>Warnings</span>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data - ->
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                    <li>
                                        <a href="#">
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
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
                                            <i class="fa fa-user success"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-dashboard warning"></i> You changed your username
                                        </a>
                                    </li>
                                </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 43px; opacity: 0.4; display: none; border-radius: 0px; z-index: 99; right: 1px; height: 156.862745098039px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li-->
<?php
                $history = History::find()->where('create_by = "'.Yii::$app->user->id.'"')->orderBy('create_time DESC')->groupBy('url')->limit(10)->all();
                if(count($history)) {
?>
                <li class="history-menu">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-comments"></i>
                        <span>History</span>
                        <strong class="label label-success"><?= count($history);?></strong>
                    </a>
                    <ul class="dropdown-menu">
<?php
                    foreach($history as $link) {
                        $now = new DateTime(null, new DateTimeZone('Australia/Sydney'));
                        $date = new DateTime($link->create_time, new DateTimeZone('Australia/Sydney'));
                        echo '
                                <li>
                                    <a href="'.$link->url.'">
                                        <h4>'.$link->name.'
                                            <small class="pull-right"><i class="fa fa-clock-o"></i> '.Yii::$app->formatter->asRelativeTime($date, $now). '</small>
                                        </h4>
                                        <p>'.$link->type.'</p>
                                    </a>
                                </li>';
                    }
?>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
<?php                 
                }
?>
<?php
                $bookmarks = Bookmark::find()->where('create_by = "'.Yii::$app->user->id.'"')->andWhere('status = "active"')->orderBy('(reminder IS NULL), reminder ASC')->limit(10)->all();
                $bookmarkList = '';
                $counter = 0;
                foreach($bookmarks as $bookmark) {
                    $icon = '<i class="fa fa-bookmark"></i>';
                    switch ($bookmark->typeIcon) {
                        case 'reminder':
                            $icon = '<i class="fa fa-clock-o"></i>';
                            break;
                        case 'passed-reminder':
                            $icon = '<i class="fa fa-exclamation-triangle text-danger"></i>';
                            break;
                    }
                    $bookmarkList .= '<li>' . Html::a($icon . $bookmark->name, $bookmark->url, ['class' => 'col-md-11', 'data-pjax' => "0"]) . Html::a('<i class="fa fa-edit"></i>', '#add-bookmark', ['data-details' => Url::toRoute(['/core/bookmarks/details', 'id' => $bookmark->id]), 'data-pjax' => '0', 'class' => "edit-bookmark col-md-1", 'data-toggle' => "modal", 'data-pjax' => "0"]) . '</li>';
                    if($bookmark->hasExpired())
                        $counter ++;
                }
                ?>
                <li class="dropdown bookmarks-menu has-plus">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bookmark"></i>
                        <span>Bookmarks</span>
                        <?php if($counter) { ?>
                        <strong class="label label-danger"><?= $counter;?></strong>
                        <?php } ?>
                    </a>
                    <?php /*Pjax::begin(['options' => ['id'=>'bookmark-list']]); */?>
                        <ul class="dropdown-menu bookmarks">
                            <?= $bookmarkList?>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    <?php /*Pjax::end(); */?>
                </li>
                <li class="is-plus">
                    <a href="#add-bookmark" class="add-bookmark" data-toggle="modal"><i class="fa fa-plus-square"></i> </a>
                </li>
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

<!-- Form modal -->
<div id="add-bookmark" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title">Add Bookmark</h5>
            </div>

            <!-- Form inside modal -->
            <?php
            $bookmark = new Bookmark;
            $bookmark->url = Yii::$app->request->url;
            $bookmark->name = $this->title;
            $form = ActiveForm::begin([
                'action' => ['/core/bookmark/save'],
                'method' => 'post',
                'id' => 'bookmark',
                'options' => [
                    'role' => "form",
                ],
                'enableClientValidation' => true,
                'validateOnSubmit' => true,
                'validateOnChange' => false,
                'fieldConfig' => [
                    'template' => "<div class=\"row\"><div class=\"col-sm-2\">{label}</div>\n<div class=\"col-sm-10\">{input}</div></div>",
                ]
            ]);
            ?>
            <div class="modal-body has-padding">
                <?= Html::activeHiddenInput($bookmark, 'id') ?>
                <?= $form->field($bookmark, 'name')->textInput(['data-default' => $bookmark->name]) ?>
                <?= $form->field($bookmark, 'url')->textInput(['data-default' => $bookmark->url]) ?>
                <?= $form->field($bookmark, 'reminder')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Enter reminder time ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'M dd, yyyy HH:ii p'
                    ]
                ]);?>
                <?= $form->field($bookmark, 'description')->textArea() ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<!-- /form modal -->

<?php $this->endPage() ?>