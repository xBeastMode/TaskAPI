<?php
namespace TaskAPIExamplePlugin;
use pocketmine\plugin\PluginBase;
use TaskAPI\Base;
class Main extends PluginBase{
    /**
     * @var int
     */
    private $ticks = 0;
    public function onEnable(){
        if($this->getServer()->getPluginManager()->getPlugin('TaskAPI') !== null){
            $this->getLogger()->info('TaskAPI found! Enabling plugin...');
            Base::getInstance()->getTaskAPI()->repeatingTask('task_api_example_task', 1, [$this, 'callback']);//repeating task every 1 second
            return;
        }
        $this->getLogger()->notice('TaskAPI not found. Disabling plugin...');
        $this->getServer()->getPluginManager()->disablePlugin($this);
    }
    public function callback(){
        $this->getLogger()->info("Ticks passed: " . $this->ticks);
        ++$this->ticks;
    }
}