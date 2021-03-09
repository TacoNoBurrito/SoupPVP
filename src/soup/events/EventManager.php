<?php
namespace soup\events;
use pocketmine\math\Vector3;
use soup\Main;
class EventManager {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function startEvent($type) {
		switch($type) {
			case "1v1":
				$this->plugin->getServer()->broadcastMessage("§e§lEVENT!§r\n§bA OneVsOne Event Has Just Begun! Do §e/event join§b To Join The Event.");
				$this->plugin->onevsonerunning = true;
				break;
		}
	}
	public function addToEvent($player, $type) {
		switch($type) {
			case "1v1":
				if (in_array($player->getName(), $this->plugin->queued)) {
					$player->sendMessage("§cYou Are Already In This Event!");
					return;
				}
				array_push($this->plugin->queued, $player->getName());
				$player->sendMessage("§aSuccessfully Joined Event!");
				$x = 1;
				$y = 1;
				$z = 1;
				$worldname = "1v1World";
				$player->teleport($this->plugin->getServer()->getLevelByName($worldname));
				$player->teleport(new Vector3($x, $y, $z));
				break;
		}
	}
	public function removeFromEvent($player, $type) {
		switch($type) {
			case "1v1":
				unset($this->plugin->queued[$player->getName()]);
				break;
		}
	}
	public function isInEvent($player) {
		if (in_array($player->getName(), $this->plugin->queued)) return true;
		if (in_array($player->getName(), $this->plugin->fighting)) return true;
		return false;
	}
}