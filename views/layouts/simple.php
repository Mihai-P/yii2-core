<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use core\models\AdminMenu;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use core\models\Bookmark;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use core\components\StringHelper;

use kartik\datetime\DateTimePickerAsset;
use kartik\datetime\DateTimePicker;
use yii\widgets\ActiveFormAsset;
use core\widgets\BookmarkWidget;
use core\widgets\HistoryWidget;

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
<body class="full-width <?=(YII_ENV == 'dev' ? 'theme-dark' : 'theme-light')?>">
    <?php $this->beginBody() ?>
    <div class="page-container container-fluid">
        <div class="page-content" style="padding-top">
            <?= $content ?>
        </div>
    </div>
        

    <?php $this->endBody() ?>
</body>
</html>

<?php $this->endPage() ?>
