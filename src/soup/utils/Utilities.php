<?php
namespace soup\utils;

use soup\Main;

class Utilities {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function quickCheck($player) {
		/**
		 * This is the check for purchases in the classes part
		 */
		if (empty($this->plugin->purchasedata->get($player->getName())["ninja"])) {
			$this->plugin->purchasedata->setNested($player->getName().".ninja",false);
			$this->plugin->purchasedata->save();
		}
		if (empty($this->plugin->purchasedata->get($player->getName())["tank"])) {
			$this->plugin->purchasedata->setNested($player->getName().".tank",false);
			$this->plugin->purchasedata->save();
		}
		if (empty($this->plugin->purchasedata->get($player->getName())["archer"])) {
			$this->plugin->purchasedata->setNested($player->getName().".archer",false);
			$this->plugin->purchasedata->save();
		}
		if (empty($this->plugin->purchasedata->get($player->getName())["launcher"])) {
			$this->plugin->purchasedata->setNested($player->getName().".launcher",false);
			$this->plugin->purchasedata->save();
		}
		if (empty($this->plugin->purchasedata->get($player->getName())["freeze"])) {
			$this->plugin->purchasedata->setNested($player->getName().".freeze",false);
			$this->plugin->purchasedata->save();
		}
		/**
		 * This is the check for purchases in the abilities part
		 */
		if (!$this->plugin->abilitydata->exists($player->getName())) {
			$this->plugin->abilitydata->set($player->getName(), [
				"monster-purchased" => false,
				"monster-level" => 0
			]);
			$this->plugin->abilitydata->save();
		}
	}
	public function handleKillStreak($player) : void {
		if ($this->plugin->playerdata->get($player->getName())["killstreak"] == 0) return;
		if (is_int($this->plugin->playerdata->get($player->getName())["killstreak"] / 5)) {
			$this->plugin->getServer()->broadcastMessage("§e".$player->getName()." Is Now On A Killstreak Of §c".$this->plugin->playerdata->get($player->getName())["killstreak"]."!");
		}
		if (is_int($this->plugin->playerdata->get($player->getName())["killstreak"] / 50)) {
			$this->plugin->getServer()->broadcastMessage("§l§cNUKE! §r§e".$player->getName()." Has Gotten a Killstreak of 50! And has dropped a nuke!");
			foreach($this->plugin->getServer()->getOnlinePlayers() as $playerz) {
				if ($this->plugin->classes[$player->getName()] == "idling") {

				} else {
					if ($playerz->getName() == $player->getName()) {

					} else {
						$playerz->kill();
					}
				}
			}
			$this->plugin->playerdata->setNested($player->getName().".kills", $this->plugin->playerdata->get($player->getName())["kills"] + count($this->plugin->getServer()->getOnlinePlayers()));
			$this->plugin->playerdata->save();
		}
	}
	public function updateNametag($player) {
		$player->setNameTag("§f".$player->getName()."\n§7[§c".round($player->getHealth())."§7]");
	}
	public function isWin10($player) : bool {
		return $this->plugin->os[$player->getName()] == "win10";
	}
}