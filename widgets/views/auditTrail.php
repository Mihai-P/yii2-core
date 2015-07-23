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
            'label' => 'Model',
            'value' => function($model) {
                return substr($model->model, strrpos($model->model, '\\') + 1);
            }
        ],
        [
            'label' => 'ID',
            'value' => function($model) {
                return $model->id;
            }
        ],
        'action',
        [
            'label' => 'Field',
            'value' => function($model) {
                return $model->getParent()->getAttributeLabel($model->field);
            }
        ],
        [
            'label' => 'Old Value',
            'value' => function($model) {
                $data = @unserialize($model->old_value);
                if ($data !== false) {
                    return print_r($data, true);
                } else {
                    return $model->old_value;
                }
            }
        ],
        [
            'label' => 'New Value',
            'value' => function($model) {
                $data = @unserialize($model->new_value);
                if ($data !== false) {
                    return print_r($data, true);
                } else {
                    return $model->new_value;
                }
            }
        ],
        [
            'label' => 'Author',
            'value' => function($model) {
                return $model->user ? $model->user->name : "";
            }
        ],
        [
            'label' => 'Date Changed',
            'value' => function($model) {
                return Yii::$app->formatter->asDateTime($model->stamp, 'medium');
            }
        ]
    ]
]); ?>