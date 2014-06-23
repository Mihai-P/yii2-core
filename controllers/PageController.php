<?php

namespace core\controllers;

use core\components\Controller;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    var $MainModel = 'core\models\Page';
    var $MainModelSearch = 'core\models\PageSearch';
}