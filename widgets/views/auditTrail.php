<?php
use theme\widgets\GridView;
use yii\data\ActiveDataProvider;
?>
<?= GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => $criteria,
        'pagination' => [
            'pageSize' => 100,
        ]
    ]),
    'columns' => [
        [
            'label' => 'Author',
            'value' => function($model, $index, $widget){
                return $model->user ? $model->user->name : "";
            }
        ],
        [
            'attribute' => 'model',
            'value' => function($model, $index, $widget){
                $p = explode('\\', $model->model);
                return end($p);
            }
        ],
        'model_id',
        'action',
        [
            'label' => 'Field',
            'value' => function($model, $index, $widget){
                return $model->getParent()->getAttributeLabel($model->field);
            }
        ],
        'old_value',
        'new_value',
        [
            'label' => 'Date Changed',
            'value' => function($model, $index, $widget){
                return Yii::$app->formatter->asDateTime($model->stamp, 'medium');
            }
        ]
    ]
]); ?>