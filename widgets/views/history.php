<?php
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

if($criteria->count()) {
?>
<li class="history-menu">
    <a class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-comments"></i>
        <span>History</span>
        <strong class="label label-success"><?= $criteria->count();?></strong>
    </a>
    <?= ListView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $criteria,
        ]),
        'itemOptions' => ['tag' => false],
        'options' => ['tag' => 'ul', 'class' => 'dropdown-menu'],
        'layout' => "{items}",
        'itemView' => '_history_item',
    ]) ?>
</li>
<?php } ?>