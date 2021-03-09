<?php
namespace soup\perks;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;
use soup\Main;

class PerksManager {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function checkPerksAfterKill(Player $player) : void {
		if (!empty($this->plugin->abilitydata->get($player->getName())["monster-purchased"])) {
			if ($this->plugin->abilitydata->get($player->getName())["monster-purchased"]) {
				$player->sendMessage("§aYou Have Gained Strength For " . ($this->plugin->abilitydata->get($player->getName())["monster-level"] * 2) . " Seconds.");
				$effect = new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20 * ($this->plugin->abilitydata->get($player->getName())["monster-level"] * 2), 1);
				$player->addEffect($effect);
			}
		}
	}
}