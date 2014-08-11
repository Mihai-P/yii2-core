<?php

namespace core\controllers;

use Yii;
use core\components\Controller;
use core\models\Object;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    var $MainModel = 'core\models\Page';
    var $MainModelSearch = 'core\models\PageSearch';

    public function afterCreate($model) {
    	$model->saveObjects();
        parent::afterCreate($model);
    }

    public function afterUpdate($model) {
        $model->saveObjects();
        parent::afterUpdate($model);
    }    
}