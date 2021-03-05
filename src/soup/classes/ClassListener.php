<?php
namespace soup\classes;
use pocketmine\block\Glass;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\MushroomStew;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use soup\classes\abilitytasks\FreezerAbilityTask;
use soup\classes\abilitytasks\LauncherAbilityTask;
use soup\Main;

class ClassListener implements Listener {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onInteract(PlayerInteractEvent $event) {
		switch ($this->plugin->classes[$event->getPlayer()->getName()]) {
			case "ninja":
				if ($event->getItem()->getCustomName() == "Ninja Ability") {
					if (isset($this->plugin->ninjacooldown[$event->getPlayer()->getName()]) and time() - $this->plugin->ninjacooldown[$event->getPlayer()->getName()] < 20) {
						$event->getPlayer()->sendMessage("§cThis Ability Is Still On Cooldown!");
					} else {
						$event->getPlayer()->sendMessage("§aSuccesfully Used Ninja Ability!");
						$this->plugin->ninjacooldown[$event->getPlayer()->getName()] = time();
						$effect = new EffectInstance(Effect::getEffect(Effect::INVISIBILITY), 20 * 5, 1);
						$event->getPlayer()->addEffect($effect);
						$effect = new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20 * 5, 0);
						$event->getPlayer()->addEffect($effect);
					}
				}
				break;

		}
	}
	public function onDamage(EntityDamageByEntityEvent $event) {
		if ($event->getEntity() instanceof Player and $event->getDamager() instanceof Player) {
			if ($this->plugin->classes[$event->getEntity()->getName()] == "idling") return;
			if ($event->getDamager()->getInventory()->getItemInHand()->getCustomName() == "Launcher Ability") {
					if (isset($this->plugin->launchercooldown[$event->getDamager()->getName()]) and time() - $this->plugin->launchercooldown[$event->getDamager()->getName()] < 60) {
						$event->getDamager()->sendMessage("§cThis Ability Is Still On Cooldown!");
					} else {
						$this->plugin->getScheduler()->scheduleRepeatingTask(new LauncherAbilityTask($event->getEntity(), $this->plugin), 10);
						$event->getDamager()->sendMessage("§aSuccesfully Used Launcher Ability!");
						$this->plugin->launchercooldown[$event->getDamager()->getName()] = time();
					}
			} else if ($event->getDamager()->getInventory()->getItemInHand()->getCustomName() == "Freezer Ability") {
				if (isset($this->plugin->freezercooldown[$event->getDamager()->getName()]) and time() - $this->plugin->freezercooldown[$event->getDamager()->getName()] < 60) {
					$event->getDamager()->sendMessage("§cThis Ability Is Still On Cooldown!");
				} else {
					$this->plugin->getScheduler()->scheduleRepeatingTask(new FreezerAbilityTask($this->plugin,$event->getEntity()), 20);
					$event->getDamager()->sendMessage("§aSuccesfully Used Freezer Ability!");
					$this->plugin->freezercooldown[$event->getDamager()->getName()] = time();
				}
			}
		}
	}
}