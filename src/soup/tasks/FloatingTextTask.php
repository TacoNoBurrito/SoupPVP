<?php
namespace soup\tasks;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use soup\Main;
class FloatingTextTask extends Task {
	private $plugin;
	private $bool = false;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onRun(int $currentTick) : void {
		if (!$this->bool) {
			$this->bool = true;
			$this->plugin->leaderBoard->setTitle($this->plugin->getKillsLeaderboard());
			$this->plugin->getServer()->getDefaultLevel()->addParticle($this->plugin->leaderBoard);
		} else {
			$this->bool = false;
			$this->plugin->leaderBoard->setTitle($this->plugin->getBestOnlineKills());
			$this->plugin->getServer()->getDefaultLevel()->addParticle($this->plugin->leaderBoard);
		}
	}
}