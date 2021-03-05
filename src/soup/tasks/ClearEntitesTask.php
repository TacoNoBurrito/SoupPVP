<?php
namespace soup\tasks;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use soup\Main;
class ClearEntitesTask extends Task {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onRun(int $currentTick) : void {
		foreach($this->plugin->getServer()->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if(!$entity instanceof Player) $entity->close();
			}
		}
	}
}