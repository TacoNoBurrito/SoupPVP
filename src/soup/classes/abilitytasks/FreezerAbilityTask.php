<?php
namespace soup\classes\abilitytasks;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\SnowballPoofParticle;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\Player;
use soup\Main;

class FreezerAbilityTask extends Task {
	private $player;
	private $plugin;
	private $count = 0;
	private $started = false;
	public function __construct(Main $plugin, Player $player) {
		$this->plugin = $plugin;
		$this->player = $player;
	}
	public function onRun(int $tick) {
		if (!$this->started) {
			$this->player->teleport(new Vector3(round($this->player->getX()), round($this->player->getY()), $this->player->getZ()));
			$this->player->sendMessage("§cThe Freezer Ability Has Just Been Used On You, You Are Frozen For 5 Seconds.");
			$this->player->setImmobile(true);
			$this->started = true;
		} else {
			$this->count++;
			$level = $this->player->getLevel();
			$x = $this->player->getX();
			$y = $this->player->getY();
			$z = $this->player->getZ();
			$center = new Vector3($x, $y + 0.5, $z);
			$particle = new SnowballPoofParticle($center);

			for ($yaw = 0, $y = $center->y; $y < $center->y + 2; $yaw += (M_PI * 2) / 20, $y += 1 / 20) {
				$x = -sin($yaw) + $center->x;
				$z = cos($yaw) + $center->z;
				$particle->setComponents($x, $y + 0.5, $z);
				$level->addParticle($particle);
			}
			if ($this->count == 5) {
				$this->player->setImmobile(false);
				$this->plugin->getScheduler()->cancelTask($this->getTaskId());
			}
		}
	}
}