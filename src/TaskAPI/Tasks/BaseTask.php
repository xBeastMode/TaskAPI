<?php
namespace TaskAPI\Tasks;
use TaskAPI\Base;
use pocketmine\scheduler\PluginTask;
class BaseTask extends PluginTask{
    /**
     * @var Base
     */
    private $base;
    /**
     * @var $callback
     */
    private $callback;
    /**
     * @var bool
     */
    public $isPaused = false;
    protected $secondsPassed = 0;
    public function __construct(Base $base, $callback){
        parent::__construct($base);
        $this->callback = $callback;
        $this->base = $base;
    }
    /**
     * @param bool|true $bool
     */
    public function setPaused($bool = true){
        $this->isPaused = $bool;
    }
    /**
     * @return bool
     */
    public function isPaused(){
        return $this->isPaused;
    }
    /**
     * Actions to execute when run
     *
     * @param $currentTick
     *
     * @return void
     */
    public function onRun($currentTick){
        if($this->isPaused) return;
        call_user_func($this->callback);
    }
}