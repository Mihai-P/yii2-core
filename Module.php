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

    public $pageTemplates = ['_simple' => 'Simple']; // 30 days

    public $attemptsBeforeCaptcha = 3; // Unsuccessful Login Attempts before Captcha

	public function init()
	{
		parent::init();

		\Yii::$app->getI18n()->translations['core.*'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'basePath' => __DIR__.'/messages',
		];
		$this->setAliases([
			'@core' => __DIR__
		]);
    }
}