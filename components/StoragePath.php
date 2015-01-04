<?php
/**
 * Date: 23.01.14
 * Time: 22:47
 */

namespace core\components;

use Yii;
use yii\helpers\ArrayHelper;
use mihaildev\elfinder\BasePath;

class StoragePath extends BasePath {

    public $path;

    public $name = 'Root';

    public $url;

    public $options = [];

    public $access = ['read' => '*', 'write' => '*'];

    public function getRoot(){
        $options['driver'] = $this->driver;
        $options['path'] = $this->path;
        $options['URL'] = $this->url;
        $options['defaults'] = $this->getDefaults();
        $options['alias'] = $this->getAlias();
        $options['mimeDetect'] = 'internal';
        //$options['onlyMimes'] = ['image'];
        $options['imgLib'] = 'gd';
        $options['attributes'][] = [
            'pattern' => '#.*(\.tmb|\.quarantine)$#i',
            'read' => false,
            'write' => false,
            'hidden' => true,
            'locked' => true
        ];

        return ArrayHelper::merge($options, $this->options);
    }
} 