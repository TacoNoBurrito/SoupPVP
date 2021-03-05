<?php
namespace soup\tasks;
use pocketmine\scheduler\Task;
use pocketmine\Player;
use soup\Main;

class CoolJoinTask extends Task {
	private $plugin;
	private $player;
	private $count = 0;
	public function __construct(Main $plugin, Player $player) {
		$this->plugin = $plugin;
		$this->player = $player;
	}
	public function onRun(int $tick) : void {
		$this->count++;
		switch($this->count) {
			case 1:
				$this->player->sendTitle("§aWelcome To HydroHCF SoupPVP!");
				$this->player->sendSubTitle("§aLoading You In...");
				break;
			case 3:
				$this->player->sendTitle("§aGameType: ".$this->plugin->os[$this->player->getName()]);
				$this->player->sendSubTitle($this->plugin::getUtils()->isWin10($this->player) ? "Form Type: Inventory UI" : "Form Type: Form UI");
				break;
			case 5:
				$this->player->sendMessage("§aSuccessfully Initialized.\nHave Fun.");
				$this->player->setImmobile(false);
				$this->plugin->getScheduler()->cancelTask($this->getTaskId());
				break;
		}
	}
}