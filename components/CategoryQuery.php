<?php
namespace core\components;
use creocoder\behaviors\NestedSetQuery;

class CategoryQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            [
                'class' => NestedSetQuery::className(),
            ],
        ];
    }
}