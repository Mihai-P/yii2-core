<?php
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\web\JsExpression;

$this->title = 'Create Group';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

		echo InputFile::widget([
		    'language'   => 'en',
		    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
		    'filter'     => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
		    'name'       => 'myinput',
		]);


		echo ElFinder::widget([
		    'language'         => 'en',
		    'controller'       => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
		    'filter'           => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
		    'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
		]);
