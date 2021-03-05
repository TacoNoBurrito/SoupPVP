<?php
namespace soup\classes;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\scheduler\Task;
use soup\Main;
class ClassTask extends Task {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onRun(int $tick) : void {
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
			if (isset($this->plugin->classes[$player->getName()])) {
				switch ($this->plugin->classes[$player->getName()]) {
					case "archer":
					case "launcher":
					case "freeze":
						$effect = new EffectInstance(Effect::getEffect(Effect::SPEED), 20 * 5, 1);
						$player->addEffect($effect);
						$effect = new EffectInstance(Effect::getEffect(Effect::RESISTANCE), 20 * 5, 0);
						$player->addEffect($effect);
						break;
					case "tank":
						$effect = new EffectInstance(Effect::getEffect(Effect::SLOWNESS), 20 * 5, 0);
						$player->addEffect($effect);
						break;
					case "ninja":
						$effect = new EffectInstance(Effect::getEffect(Effect::SPEED), 20 * 5, 1);
						$player->addEffect($effect);
						$effect = new EffectInstance(Effect::getEffect(Effect::RESISTANCE), 20 * 5, 1);
						$player->addEffect($effect);
						break;
				}
			}
		}
	}
}