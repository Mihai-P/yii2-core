<?php
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use theme\widgets\Pjax;
?>
    <li class="dropdown bookmarks-menu has-plus">
        <?php /*Pjax::begin(['options' => ['id'=>'bookmark-list']]); */?>
        <a class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bookmark"></i>
            <span>Bookmarks</span>
            <strong class="label label-danger"><?= $counter;?></strong>
        </a>

            <?= ListView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $criteria,
                ]),
                'itemOptions' => ['tag' => false],
                'options' => ['tag' => 'ul', 'class' => 'dropdown-menu bookmarks'],
                'layout' => "{items}<li class=\"footer\">" . Html::a('View All', ['/core/bookmark'], ['data-pjax' => '0']) . "</li>",
                'itemView' => '_bookmark_item',
            ]) ?>
        <?php /*Pjax::end(); */?>
    </li>
    <li class="is-plus">
        <a href="#add-bookmark" class="add-bookmark" data-toggle="modal"><i class="fa fa-plus-square"></i> </a>
    </li>