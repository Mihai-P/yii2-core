<?php

namespace core\controllers;

use core\components\Controller;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
{
    var $MainModel = 'core\models\Tag';
    var $MainModelSearch = 'core\models\TagSearch';
}