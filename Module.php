<?php

namespace core;


class Module extends \yii\base\Module
{
	public $controllerNamespace = 'core\controllers';

    /**
     * @var int
     * @desc Remember Me Time (seconds), default = 2592000 (30 days)
     */
    public $rememberMeTime = 2592000; // 30 days

    /**
     * @var array
     * @desc User model relation from other models
     * @see http://www.yiiframework.com/doc/guide/database.arr
     */
    public $relations = array();

    public $tableMap = array(
        'User' => 'User',
        'UserStatus' => 'UserStatus',
        'ProfileFieldValue' => 'ProfileFieldValue',
        'ProfileField' => 'ProfileField',
        'ProfileFieldType' => 'ProfileFieldType',
    );

    public $layoutLogged;

    public $attemptsBeforeCaptcha = 3; // Unsuccessful Login Attempts before Captcha

    public $referralParam = 'ref';

	public $superAdmins = ['admin'];

	public function init()
	{
		parent::init();

		\Yii::$app->getI18n()->translations['core.*'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'basePath' => __DIR__.'/messages',
		];
		$this->setAliases([
			'@core' => __DIR__
		]);	}

}
