<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace core\components;

use yii\base\Event;

/**
 * ControllerEvent represents the information available in [[Controller::EVENT_AFTER_CREATE]] and [[Controller::EVENT_AFTER_UPDATE]].
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @since 2.0
 */
class ControllerEvent extends Event
{
    /**
     * @var Model The model that has been updated / inserted
     */
    public $model;

    /**
     * @var Controller The controller that raised the event
     */
    public $controller;
}
