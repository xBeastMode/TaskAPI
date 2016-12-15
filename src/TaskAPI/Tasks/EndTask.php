<?php
namespace TaskAPI\Tasks;
use TaskAPI\Base;
use pocketmine\scheduler\PluginTask;
class EndTask extends PluginTask{
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
        $this->base->getTaskAPI()->terminateTask($this->task_name);
        $this->base->getServer()->getScheduler()->cancelTask($this->getTaskId());
    }
}