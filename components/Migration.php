<?php
/**
 * Migration provides some default starting data.
 */

namespace core\components;

use yii\db\Query;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Migration provides some default starting data.
 */
class Migration extends \yii\db\Migration
{
    var $controller;
    var $menu = 'Misc';
    var $module = '';
    var $singleMenu = false;
    var $privileges = ['create', 'delete', 'read', 'update'];

    /**
     * Transforms the name of the controller to a more user friendly one
     *
     * @param string $str the string that will be made friendly
     * @return string the friendly string
     */
    public function friendly($str) {
        return Inflector::pluralize(Inflector::camel2words(StringHelper::basename($str)));
    }

    /**
     * Returns the name of the controller
     *
     * @return string the name of the controller
     */
    public function getController() {
        if(!empty($this->controller)) {
            return $this->controller;
        } else {
            preg_match('@(?:m[a-zA-Z0-9]{1,})_([a-zA-Z0-9]{1,})_(?:create)_([^/]+)_(?:table)@i', get_class($this), $matches);
            return $matches[2];
        }
    }

    /**
     * Creates the AuthItems for a controller
     *
     * @return null
     */
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

    /**
     * Deletes the AuthItems for the controller
     *
     * @return null
     */
    public function deleteAuthItems() {
        foreach($this->privileges as $privilege) {
            $this->delete(
                'AuthItem',"name = '".$privilege.'::'.$this->getController()."'"
            );
        }
    }

    /**
     * Inserts the AdminMenus for the controller
     *
     * @return null
     */
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

    /**
     * Deletes the Admin Menu for the controller
     *
     * @return null
     */
    public function deleteAdminMenu() {
        $this->delete(
            'AdminMenu',"internal = '".$this->getController()."Controller'"
        );
    }
}