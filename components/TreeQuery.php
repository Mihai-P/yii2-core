<?php
namespace core\components;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class TreeQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}