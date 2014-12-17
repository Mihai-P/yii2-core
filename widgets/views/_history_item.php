<?php
$now = new DateTime(null, new DateTimeZone('Australia/Sydney'));
$date = new DateTime($model->create_time, new DateTimeZone('Australia/Sydney'));
?>
<li>
    <a href="<?= $model->url?>">
        <h4><?= $model->name ?>
            <small class="pull-right"><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asRelativeTime($date, $now) ?></small>
        </h4>
        <p><?= $model->type?></p>
    </a>
</li>