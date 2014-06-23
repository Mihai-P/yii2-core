<?php

namespace core\controllers;

use core\components\Controller;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
{
    var $MainModel = 'core\models\Contact';
    var $MainModelSearch = 'core\models\ContactSearch';
}