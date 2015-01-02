<?php
namespace core\components;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class NestedQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}