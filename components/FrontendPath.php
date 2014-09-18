<?php
/**
 * Date: 23.01.14
 * Time: 22:47
 */

namespace core\components;
use mihaildev\elfinder\BasePath;
use Yii;

class FrontendPath extends BasePath {
    public $path;

    public $name = 'Root';

    public $url;

    public $options = [];

    public $access = ['read' => '*', 'write' => '*'];

    public function getUrl(){
        if(empty($this->url)) {
            return Yii::getAlias('@web/'.trim($this->path,'/'));
        } else {
            return $this->url;
        }
    }

    public function getRealPath(){
        $path = Yii::getAlias('@webroot/'.trim($this->path,'/'));
        if(!is_dir($path))
            mkdir($path, 0777, true);

        return $path;
    }

    public function getRoot(){
        $options['driver'] = $this->driver;
        $options['path'] = $this->getRealPath();
        $options['URL'] = $this->getUrl();
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

        return \yii\helpers\ArrayHelper::merge($options, $this->options);
    }
} 