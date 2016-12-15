<?php
namespace TaskAPI\Tasks;
use TaskAPI\Base;
use pocketmine\scheduler\PluginTask;
class UnPauseTask extends PluginTask{
    /**
     * @var string
     */
    private $task_name;
    /**
     * @var Base
     */
    private $base;
    public function __construct(Base $base, $task_name){
        parent::__construct($base);
        $this->task_name = $task_name;
        $this->base = $base;
    }
    /**
     * Actions to execute when run
     *
     * @param $currentTick
     *
     * @return void
     */
    public function onRun($currentTick){
        $this->base->getTaskAPI()->unPauseTask($this->task_name);
        $this->base->getServer()->getScheduler()->cancelTask($this->getTaskId());
    }
}