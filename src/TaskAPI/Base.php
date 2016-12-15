<?php
namespace TaskAPI;
use pocketmine\plugin\PluginBase;
class Base extends PluginBase{
    /**
     * @var Base
     */
    public static $instance;
    /**
     * @var API
     */
    private $api;

    /**
     * @return Base
     */
    public static function getInstance(): Base{
        return self::$instance;
    }

    public function onLoad(){
        self::$instance = $this;
    }

    public function onEnable(){
        $this->api = new API($this);
    }

    /**
     * @return API
     */
    public function getTaskAPI(){
        return $this->api;
    }
}