<?php

namespace core\controllers;

use core\components\Controller;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
{
    var $MainModel = 'core\models\Group';
    var $MainModelSearch = 'core\models\GroupSearch';
}