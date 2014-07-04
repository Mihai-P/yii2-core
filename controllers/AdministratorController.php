<?php

namespace core\controllers;

use core\components\Controller;

/**
 * AdministratorController implements the CRUD actions for Administrator model.
 */
class AdministratorController extends Controller
{
    var $MainModel = 'core\models\Administrator';
    var $MainModelSearch = 'core\models\AdministratorSearch';
}