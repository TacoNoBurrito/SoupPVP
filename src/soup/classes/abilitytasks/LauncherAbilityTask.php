<?php
namespace soup\classes\abilitytasks;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\Player;
use pocketmine\level\particle\FlameParticle;
use soup\Main;

class LauncherAbilityTask extends Task {
	private $player;
	private $plugin;
	public function __construct(Player $player, Main $plugin) {
		$this->player = $player;
		$this->plugin = $plugin;
	}
	private $time = 0;
	private $init = false;
	public function onRun(int $tick) {
		if (!$this->init) {
			$pos = $this->player->getPosition();
			$radio = 1;
			for ($y = 0; $y < 2; $y += 0.2) {
				$x = $radio * cos($y);
				$z = $radio * sin($y);
				$particle = new FlameParticle($pos->add($x, $y, $z));
				$pos->getLevel()->addParticle($particle);
			}
			for ($y = 0; $y < 2; $y += 0.2) {
				$x = -$radio * cos($y);
				$z = -$radio * sin($y);
				$particle = new FlameParticle($pos->add($x, $y, $z));
				$pos->getLevel()->addParticle($particle);
			}
			$this->player->sendMessage("§cA Launcher Ability Has Been Used On You.");
			$this->player->setImmobile(true);
			$this->player->teleport(new Vector3($this->player->getX(), $this->player->getY() + 1.5, $this->player->getZ()));
			$this->init = true;
		} else {
			$pos = $this->player->getPosition();
			$radio = 1;
			for ($y = 0; $y < 2; $y += 0.2) {
				$x = $radio * cos($y);
				$z = $radio * sin($y);
				$particle = new FlameParticle($pos->add($x, $y, $z));
				$pos->getLevel()->addParticle($particle);
			}
			for ($y = 0; $y < 2; $y += 0.2) {
				$x = -$radio * cos($y);
				$z = -$radio * sin($y);
				$particle = new FlameParticle($pos->add($x, $y, $z));
				$pos->getLevel()->addParticle($particle);
			}
			$this->time++;
			$this->player->teleport(new Vector3($this->player->getX(), $this->player->getY() + 1.5, $this->player->getZ()));
			switch ($this->time) {
				case 2:
					$pos = $this->player->getPosition();
					$radio = 1;
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = $radio * cos($y);
						$z = $radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = -$radio * cos($y);
						$z = -$radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					break;
				case 4:
					$pos = $this->player->getPosition();
					$radio = 1;
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = $radio * cos($y);
						$z = $radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = -$radio * cos($y);
						$z = -$radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					break;
				case 5:
					$pos = $this->player->getPosition();
					$radio = 1;
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = $radio * cos($y);
						$z = $radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = -$radio * cos($y);
						$z = -$radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					break;
				case 6:
					$pos = $this->player->getPosition();
					$radio = 1;
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = $radio * cos($y);
						$z = $radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = -$radio * cos($y);
						$z = -$radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					break;
				case 8:
					$pos = $this->player->getPosition();
					$radio = 1;
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = $radio * cos($y);
						$z = $radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					for ($y = 0; $y < 2; $y += 0.2) {
						$x = -$radio * cos($y);
						$z = -$radio * sin($y);
						$particle = new FlameParticle($pos->add($x, $y, $z));
						$pos->getLevel()->addParticle($particle);
					}
					$this->player->setImmobile(false);
					$this->plugin->getScheduler()->cancelTask($this->getTaskId());
					break;
			}
		}
	}
}