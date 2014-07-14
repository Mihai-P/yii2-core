<?php
namespace core\components;

use yii\base\Behavior;
use core\components\ActiveRecord;
use core\models\History;

class HistoryBehavior extends Behavior
{
    public $attr = "name";

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            
        ];
    }

    public function afterInsert() {
        $this->createHistory();
    }

    public function afterUpdate() {
        $this->createHistory();
    }

    private function createHistory() {
        $model = $this->owner;
        if(isset($model->{$this->attr})) {
            $url_components = explode("\\", get_class($model));
            $url_components[2] = trim(preg_replace("([A-Z])", " $0", $url_components[2]), " ");

            $history = new History;
            $history->name = $model->{$this->attr} . ' ('.$url_components[2].')';
            $history->url = $this->guessUrl($model);
            $history->detachBehavior('history');
            $history->save();
        }        
    }

    private function guessUrl($model) {

        $url_components = explode("\\", get_class($model));
        $url_components[2] = trim(preg_replace("([A-Z])", "-$0", $url_components[2]), "-");
        switch($url_components[0]) {
            case "common":
            case "backend":
                $url = $url_components[2] . "/update?id=" . $model->id;
                break;
            default: 
                $url = $url_components[0] . "/" . $url_components[2] . "/update?id=" . $model->id;
        }
        return strtolower($url);
    }    
}