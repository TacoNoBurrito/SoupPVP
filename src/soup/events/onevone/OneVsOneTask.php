<?php
namespace soup\events\onevone;
use pocketmine\scheduler\Task;
use soup\Main;
class OneVsOneTask extends Task {
	private $plugin;
	private $starting = 0;
	private $started = false;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onRun(int $tick) {
		if(!$this->started) {
			$this->starting++;
			if ($this->starting == 30) {
				$this->plugin->getServer()->broadcastMessage("§l§eEVENT!§r\n§bThe OneVsOne Event Is Starting In 30 Seconds!");
			}else if ($this->starting == 50) {
				$this->plugin->getServer()->broadcastMessage("§l§eEVENT!§r\n§bThe OneVsOne Event Is Starting In 10 Seconds!");
			} else if ($this->starting == 60) {
				$this->plugin->getServer()->broadcastMessage("§l§eEVENT!§r\n§bThe OneVsOne Event Has Started, Joining Is Now Closed!");
				$this->plugin->joinable = true;
				$this->started = true;
			}
		}
	}
}