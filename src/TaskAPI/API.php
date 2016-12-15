<?php
namespace TaskAPI;
use pocketmine\scheduler\PluginTask;
use TaskAPI\Tasks\BaseTask;
use TaskAPI\Tasks\EndTask;
use TaskAPI\Tasks\UnPauseTask;
final class API{
    /**
     * @var BaseTask[]|PluginTask[]
     */
    private $tasks = [];
    /**
     * @var Base
     */
    private $base;
    public function __construct(Base $base){
        $this->base = $base;
    }
    /**
     * @param $task_name
     */
    public function terminateTask($task_name){
        $this->killTask($task_name);
        $this->removeTask($task_name);
    }
    /**
     * @param $task_name
     */
    public function killTask($task_name){
        if ($this->taskExists($task_name)) {
            $this->base->getServer()->getScheduler()->cancelTask($this->tasks[$task_name]->getTaskId());
        }
    }
    /**
     * @param $task_name
     */
    public function unPauseTask($task_name){
        $this->tasks[$task_name]->setPaused(false);
    }
    /**
     * @param $task_name
     * @return bool
     */
    public function taskExists($task_name){
        return isset($this->tasks[$task_name]);
    }

    /**
     * @param $task_name
     * @return PluginTask|BaseTask
     */
    public function getTask($task_name){
        if($this->taskExists($task_name)){
            return $this->tasks[$task_name];
        }
        return null;
    }
    /**
     * @param $task_name
     */
    public function removeTask($task_name){
        if($this->taskExists($task_name)){
            unset($this->tasks[$task_name]);
        }
    }
    /**
     * @param string $task_name
     * @param BaseTask|PluginTask $task
     */
    public function setTaskName($task_name, $task){
        if(!$this->taskExists($task_name)){
            $this->tasks[$task_name] = $task;
            return;
        }
        echo $task_name . ' already exists in the list.';
    }
    /**
     * @param string $task_name
     * @param int $interval
     * @param $callback
     */
    public function delayedTask($task_name, $interval, $callback){
        $task = new BaseTask($this->base, $callback);
        $handler = $this->base->getServer()->getScheduler()->scheduleDelayedTask($task, $interval*20);
        $this->setTaskName($task_name, $task);
        $task->setHandler($handler);
    }
    /**
     * @param string $task_name
     * @param int $interval
     * @param $callback
     */
    public function repeatingTask($task_name, $interval, $callback){
        $task = new BaseTask($this->base, $callback);
        $handler = $this->base->getServer()->getScheduler()->scheduleRepeatingTask($task, $interval*20);
        $this->setTaskName($task_name, $task);
        $task->setHandler($handler);
    }
    /**
     * @param string $task_name
     * @param $callback
     * @param int $delay
     * @param int $interval
     */
    public function delayedRepeatingTask($task_name, $callback, $delay, $interval){
        $this->repeatingTask($task_name, $interval, $callback);
        $this->pauseTask($task_name, $delay);
    }
    /**
     * @param $task_name
     * @param int $seconds
     */
    public function pauseTask($task_name, $seconds){
        $this->tasks[$task_name]->setPaused();
        $task = new UnPauseTask($this->base, $task_name);
        $handler = $this->base->getServer()->getScheduler()->scheduleDelayedTask($task, $seconds*20);
        $task->setHandler($handler);
    }
    /**
     * @param $task_name
     * @param $seconds
     */
    public function endAfter($task_name, $seconds){
        $this->tasks[$task_name]->setPaused();
        $task = new EndTask($this->base, $task_name);
        $handler = $this->base->getServer()->getScheduler()->scheduleDelayedTask($task, $seconds*20);
        $task->setHandler($handler);
    }
}