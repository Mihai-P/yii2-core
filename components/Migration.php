<?php

namespace core\components;

use yii\db\Query;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/**
 * FaqController implements the CRUD actions for Faq model.
 */
class Migration extends \yii\db\Migration
{
    var $controller;
    var $menu = 'Misc';
    var $module = '';
    var $singleMenu = false;
    var $privileges = ['create', 'delete', 'read', 'update'];

    public function friendly($str) {
        return Inflector::pluralize(Inflector::camel2words(StringHelper::basename($str)));
        //return trim(implode(" ", preg_split('/(?=\p{Lu})/u', $str)));
    }

    public function getController() {
        if(!empty($this->controller)) {
            return $this->controller;
        } else {
            preg_match('@(?:m[a-zA-Z0-9]{1,})_([a-zA-Z0-9]{1,})_(?:create)_([^/]+)_(?:table)@i', get_class($this), $matches);
            return $matches[2];
        }
    }

    public function createAuthItems() {
        foreach($this->privileges as $privilege) {
            $this->insert('AuthItem', [
                "name" => $privilege.'::'.$this->getController(),
                "type" => 0,
                "description" => $privilege.' '.$this->getController(),
                "bizrule" => null,
                "data" => 'a:2:{s:6:"module";s:'.strlen($this->menu).':"'.$this->menu.'";s:10:"controller";s:'.strlen($this->friendly($this->getController())).':"'.$this->friendly($this->getController()).'";}',
            ]);
            $this->insert('AuthItemChild', [
                "parent" => 1,
                "child" => $privilege.'::'.$this->getController(),
            ]);
        }       
    }

    public function deleteAuthItems() {
        foreach($this->privileges as $privilege) {
            $this->delete(
                'AuthItem',"name = '".$privilege.'::'.$this->getController()."'"
            );
        }
    }

    public function createAdminMenu() {
        $connection = \Yii::$app->db;
        $query = new Query;
        if(!$this->singleMenu) {
            $menu_name = $this->friendly($this->getController());
            $menu = $query->from('AdminMenu')
                ->where('internal=:internal', [':internal'=>$this->menu])
                ->one();

            if(!$menu) {
                $query = new Query;
                // compose the query
                $last_main_menu = $query->from('AdminMenu')
                    ->where('AdminMenu_id IS NULL')
                    ->orderby('order DESC')          
                    ->one();

                $this->insert('AdminMenu', [
                    "name" => $this->menu,
                    "internal" => $this->menu,
                    "url" => '',
                    "ap" => 'read::'.$this->getController(),
                    "order" => $last_main_menu ? $last_main_menu['order'] + 1 : 1
                ]);
                $menu_id = $connection->getLastInsertID();
            } else {
                $menu_id = $menu['id'];
            }
        } else {
            $menu_id = NULL;
            $menu_name = $this->menu;
        }
        $query = new Query;

        $last_menu = $query->from('AdminMenu')
                ->from('AdminMenu')
                ->where('AdminMenu_id=:AdminMenu_id', [':AdminMenu_id'=>$menu_id])
                ->orderby('order DESC')
                ->one();

        $this->insert('AdminMenu', [
            "AdminMenu_id" => $menu_id,
            "name" => $menu_name,
            "internal" => $this->getController() . 'Controller',
            "url" => ($this->module ? '/' . $this->module : '' ) . '/'. strtolower(trim(preg_replace("([A-Z])", "-$0", $this->getController()), '-')).'/',
            "ap" => 'read::'.$this->getController(),
            "order" => $last_menu ? $last_menu['order'] + 1 : 1
        ]);
    }

    public function deleteAdminMenu() {
        $this->delete(
            'AdminMenu',"internal = '".$this->getController()."Controller'"
        );
    }
}