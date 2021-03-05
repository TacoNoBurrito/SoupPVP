<?php
namespace soup\perks;
use soup\Main;
use pocketmine\Player;
class PerkShopManager {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function buyPerk($player, $type) : void {
		switch($type) {
			case "monster":
				$purchasePrice = 750;
				$upgradePrice = 500 * $this->plugin->abilitydata->get($player->getName())["monster-level"];
				if ($this->plugin->abilitydata->get($player->getName())["monster-purchased"] == false) {
					if ($this->plugin->playerdata->get($player->getName())["credits"] >= $purchasePrice) {
						$this->plugin->abilitydata->setNested($player->getName() . ".monster-purchased", true);
						$this->plugin->abilitydata->save();
						$this->plugin->abilitydata->setNested($player->getName() . ".monster-level", 1);
						$this->plugin->abilitydata->save();
						$this->plugin->playerdata->setNested($player->getName().".credits", $this->plugin->playerdata->get($player->getName())["credits"] - $purchasePrice);
						$this->plugin->playerdata->save();
						$player->sendMessage("§aSuccessfully Purchased Monster Ability! You May Now Upgrade It!");
						return;
					} else {
						$player->sendMessage("§cYou Do Not Have Enough Credits To Do This!");
						return;
					}
				} else {
					if ($this->plugin->playerdata->get($player->getName())["credits"] >= $upgradePrice) {
						$this->plugin->playerdata->setNested($player->getName().".credits", $this->plugin->playerdata->get($player->getName())["credits"] - $upgradePrice);
						$this->plugin->playerdata->save();
						$this->plugin->abilitydata->setNested($player->getName() . ".monster-level", $this->plugin->abilitydata->get($player->getName())["monster-level"]+1);
						$this->plugin->abilitydata->save();
						$player->sendMessage("§aSuccessfully Upgraded Monster Ability!");
						return;
					} else {
						$player->sendMessage("§cYou Do Not Have Enough Credits To Do This!");
						return;
					}
				}
				break;
		}
	}
}
