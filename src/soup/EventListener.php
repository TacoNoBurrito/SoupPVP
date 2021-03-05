<?php
namespace soup;
use muqsit\invmenu\InvMenu;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\Bowl;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\MushroomStew;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\Player;
use pocketmine\tile\Sign;
use soup\tasks\CoolJoinTask;

class EventListener implements Listener {
	/**
	 * @var Main
	 */
	private $plugin;
	/**
	 * EventListener constructor.
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}


	public function onLogin(PlayerPreLoginEvent $event) {
		$this->plugin->classes[$event->getPlayer()->getName()] = "idling";
	}


	public function onData(DataPacketReceiveEvent $event) : void {
		if ($event->getPacket() instanceof LoginPacket) {
			switch ($event->getPacket()->clientData["DeviceOS"]) {
				case 10:
				case 9:
				case 6:
				case 5:
				case 4:
				case 2:
				case 1:
					$this->plugin->os[$event->getPacket()->username] = "mobile";
					break;
				case 11:
				case 8:
				case 7:
				case 3:
					$this->plugin->os[$event->getPacket()->username] = "win10";
					break;
				default:
					$this->plugin->os[$event->getPacket()->username] = "win10";
			}
		}
	}

	/**
	 * @param PlayerJoinEvent $event
	 */
	public function onJoin(PlayerJoinEvent $event) : void {
		if ($event->getPlayer()->getAddress() == ($this->plugin->getConfig()->get("proxy-only") == false ? $event->getPlayer()->getAddress() : "127.0.0.1")) {
			$this->plugin->getScheduler()->scheduleRepeatingTask(new CoolJoinTask($this->plugin, $event->getPlayer()), 20);
			$event->getPlayer()->setImmobile(true);
			$this->plugin->classes[$event->getPlayer()->getName()] = "idling";
			$event->getPlayer()->setNameTag("§f".$event->getPlayer()->getName()."\n§7[§c".round($event->getPlayer()->getHealth())."§7]");
			$event->setJoinMessage("§a+ ".$event->getPlayer()->getName());
			$this->plugin::getClassManager()->setIdlingClass($event->getPlayer());
			$this->plugin->lastkit[$event->getPlayer()->getName()] = "none";
			$this->plugin->lasthit[$event->getPlayer()->getName()] = "no one";
			if (!$this->plugin->playerdata->exists($event->getPlayer()->getName())) {
				$this->plugin->playerdata->set($event->getPlayer()->getName(), ["kills" => 0, "deaths" => 0, "killstreak" => 0, "rank" => "default", "credits" => 0]);
				$this->plugin->playerdata->save();
			} if (!$this->plugin->purchasedata->exists($event->getPlayer()->getName())) {
				$this->plugin->purchasedata->set($event->getPlayer()->getName(), ["ninja" => false, "tank" => false]);
				$this->plugin->purchasedata->save();
			}
			$this->plugin->abilitydata->set($event->getPlayer()->getName(), [
				"monster-purchased" => false,
				"monster-level" => 0
			]);
			$this->plugin->abilitydata->save();
		} else {
			$event->getPlayer()->kick("You May Only Join Through The Hub:\nHUB.HydroMC.TK Default Port.", false);
		}
	}

	/**
	 * @param PlayerChatEvent $event
	 */
	public function onChat(PlayerChatEvent $event) : void {
		if ($event->getMessage() == ".staffmode on") {
			$array = ["manager","mod","owner"];
			if (in_array($this->plugin->playerdata->get($event->getPlayer()->getName())["rank"], $array)) {
				$event->getPlayer()->setGamemode(1);
				$event->getPlayer()->getInventory()->clearAll();
				$event->getPlayer()->getArmorInventory()->clearAll();
				$event->setCancelled(true);
				$event->getPlayer()->sendMessage("§aStaffMode Enabled!");
			}
		} else if ($event->getMessage() == ".staffmode off") {
			$array = ["manager","mod","owner"];
			if (in_array($this->plugin->playerdata->get($event->getPlayer()->getName())["rank"], $array)) {
				$event->getPlayer()->setGamemode(0);
				$event->getPlayer()->setHealth(20);
				$event->getPlayer()->teleport($event->getPlayer()->getLevel()->getSafeSpawn());
				$this->plugin::getClassManager()->setIdlingClass($event->getPlayer());
				$event->setCancelled(true);
				$event->getPlayer()->sendMessage("§aStaffMode Disabled!");
			}
		} else {
			switch($this->plugin->playerdata->get($event->getPlayer()->getName())["rank"]) {
				case "manager":
					$event->setFormat("§l§bMANAGER §r§f".$event->getPlayer()->getName() . ":§7 " . $event->getMessage());
					break;
				case "owner":
					$event->setFormat("§l§cOWNER §r§f".$event->getPlayer()->getName() . ":§7 " . $event->getMessage());
					break;
				case "mod":
					$event->setFormat("§l§6MOD §r§f".$event->getPlayer()->getName() . ":§7 " . $event->getMessage());
					break;
				case "media":
					$event->setFormat("§l§dMEDIA §r§f".$event->getPlayer()->getName() . ":§7 " . $event->getMessage());
					break;
				case "hydro":
					$event->setFormat("§l§aHYDRO §r§f".$event->getPlayer()->getName() . ":§7 " . $event->getMessage());
					break;
				default:
					$event->setFormat($event->getPlayer()->getName() . ":§7 " . $event->getMessage());
			}
		}
	}

	public function onBreak(BlockBreakEvent $event) : void {
		if ($event->getPlayer()->isOp()) return;
		$event->setCancelled(true);
	}

	public function onPlace(BlockPlaceEvent $event) : void  {
		if ($event->getPlayer()->isOp()) return;
		$event->setCancelled(true);
	}

	/**
	 * @param PlayerQuitEvent $event
	 */
	public function onQuit(PlayerQuitEvent $event) : void {
		$event->setQuitMessage("§c- ".$event->getPlayer()->getName());
		unset($this->plugin->lastkit[$event->getPlayer()->getName()]);
		unset($this->plugin->lasthit[$event->getPlayer()->getName()]);
		unset($this->plugin->classes[$event->getPlayer()->getName()]);
		unset($this->plugin->os[$event->getPlayer()->getName()]);
	}

	/**
	 * @param EntityDamageEvent $event
	 */
	public function onDamage(EntityDamageEvent $event) : void {
		$type_undo = [EntityDamageEvent::CAUSE_SUFFOCATION, EntityDamageEvent::CAUSE_ENTITY_EXPLOSION];
		if (in_array($event->getCause(), $type_undo)) $event->setCancelled(true);
		if ($event->getCause() == EntityDamageEvent::CAUSE_VOID) {
			$event->setCancelled(true);
			$this->plugin::getUtils()->updateNametag($event->getEntity());
			$event->getEntity()->teleport($event->getEntity()->getLevel()->getSafeSpawn());
		} else if ($event->getCause() == EntityDamageEvent::CAUSE_FALL) {
			if ($event->getFinalDamage() >= $event->getEntity()->getHealth()) {
				if ($this->plugin->lasthit[$event->getEntity()->getName()] == "no one") {
					$this->plugin::getUtils()->updateNametag($event->getEntity());
					$event->getEntity()->setHealth(20);
					$event->getEntity()->teleport($event->getEntity()->getLevel()->getSafeSpawn());
					$this->plugin::getUtils()->updateNametag($event->getEntity());
					$event->setCancelled(true);
					$this->plugin->playerdata->setNested($event->getEntity()->getName().".deaths", $this->plugin->playerdata->get($event->getEntity()->getName())["deaths"] + 1);
					$this->plugin->playerdata->save();
				} else {
					$this->plugin::getUtils()->updateNametag($event->getEntity());
					$pl = $this->plugin->getServer()->getPlayer($this->plugin->lasthit[$event->getEntity()->getName()]);
					if ($pl == null) {
						$this->updateNametag($event->getEntity());
						$event->getEntity()->setHealth(20);
						$event->getEntity()->teleport($event->getEntity()->getLevel()->getSafeSpawn());
						$this->plugin::getUtils()->updateNametag($event->getEntity());
						$event->setCancelled(true);
						$this->plugin->playerdata->setNested($event->getEntity()->getName().".deaths", $this->plugin->playerdata->get($event->getEntity()->getName())["deaths"] + 1);
						$this->plugin->playerdata->save();
						return;
					}
					$this->plugin::getUtils()->updateNametag($event->getEntity());
					$event->getEntity()->setHealth(20);
					$event->getEntity()->teleport($event->getEntity()->getLevel()->getSafeSpawn());
					$this->plugin::getClassManager()->setIdlingClass($event->getEntity());
					$event->setCancelled(true);
					$event->getEntity()->sendMessage("§aYou Have Been Killed By §c".$this->plugin->lasthit[$event->getPlayer()->getName()]." §aWho Was Using The Class §c".$this->plugin->classes[$event->getDamager()->getName()]." Due To Fall Damage.");
					$random = mt_rand(7,20);
					$event->getDamager()->sendMessage("§aYou Have Earned §c".$random." §aCredits From Killing ".$event->getEntity()->getName()." With Fall Damage.");
					$this->plugin->playerdata->setNested($event->getDamager()->getName().".credits", $this->plugin->playerdata->get($event->getDamager()->getName())["credits"] + $random);
					$this->plugin->playerdata->save();
					$this->plugin->playerdata->setNested($event->getDamager()->getName().".kills", $this->plugin->playerdata->get($event->getDamager()->getName())["kills"] + 1);
					$this->plugin->playerdata->save();
					$this->plugin->playerdata->setNested($event->getEntity()->getName().".deaths", $this->plugin->playerdata->get($event->getEntity()->getName())["deaths"] + 1);
					$this->plugin->playerdata->save();
				}
				$event->setCancelled(true);
			}
		} else if ($event->getCause() == EntityDamageEvent::CAUSE_FIRE or $event->getCause() == EntityDamageEvent::CAUSE_FIRE_TICK) {
			$this->plugin::getUtils()->updateNametag($event->getEntity());
			if ($this->plugin->classes[$event->getEntity()->getName()] == "idling") {
				$event->setCancelled(true);
			}
		}
		if ($event instanceof EntityDamageByEntityEvent) {
			if ($event->getEntity() instanceof Player and $event->getDamager() instanceof Player) {
				$this->plugin::getUtils()->updateNametag($event->getEntity());
				$this->plugin->lasthit[$event->getEntity()->getName()] = $event->getDamager()->getName();
				// KEEP OFF UNTIL YOU FIND A GOOD REACH LIMIT if ($event->getEntity()->distance($event->getDamager()) > 4) $event->setCancelled(true);
				// TODO: Find a decent reach limit for pvp.
				if ($this->plugin->classes[$event->getEntity()->getName()] == "idling"or$this->plugin->classes[$event->getDamager()->getName()] == "idling") $event->setCancelled(true);
				if ($event->getFinalDamage() >= $event->getEntity()->getHealth()) {
					$this->plugin::getUtils()->handleKillStreak($event->getDamager());
					$event->setCancelled(true);
					$event->getEntity()->setHealth(20);
					$event->getEntity()->teleport($event->getEntity()->getLevel()->getSafeSpawn());
					$this->plugin::getClassManager()->setIdlingClass($event->getEntity());
					$event->getEntity()->sendMessage("§aYou Have Been Killed By §c".$event->getDamager()->getName()." §aWho Was Using The Class §c".$this->plugin->classes[$event->getDamager()->getName()].".");
					$random = mt_rand(7,20);
					$event->getDamager()->sendMessage("§aYou Have Earned §c".$random." §aCredits From Killing ".$event->getEntity()->getName().".");
					$this->plugin->playerdata->setNested($event->getDamager()->getName().".credits", $this->plugin->playerdata->get($event->getDamager()->getName())["credits"] + $random);
					$this->plugin->playerdata->save();
					$this->plugin->playerdata->setNested($event->getDamager()->getName().".kills", $this->plugin->playerdata->get($event->getDamager()->getName())["kills"] + 1);
					$this->plugin->playerdata->save();
					$this->plugin->playerdata->setNested($event->getEntity()->getName().".deaths", $this->plugin->playerdata->get($event->getEntity()->getName())["deaths"] + 1);
					$this->plugin->playerdata->save();
					$this->plugin->playerdata->setNested($event->getDamager()->getName().".killstreak", $this->plugin->playerdata->get($event->getDamager()->getName())["killstreak"] + 1);
					$this->plugin->playerdata->save();
					$this->plugin->playerdata->setNested($event->getEntity()->getName().".killstreak", 0);
					$this->plugin->playerdata->save();
				}
			}
		}
	}

	/**
	 * @param PlayerDropItemEvent $event
	 */
	public function onDrop(PlayerDropItemEvent $event) : void {
		if (!$event->getItem() instanceof Bowl) {
			$event->setCancelled(true);
			$event->getPlayer()->sendMessage("§cYou Might Want To Keep That Item!");
		}
	}

	/**
	 * @param PlayerInteractEvent $event
	 */
	public function onInteract(PlayerInteractEvent $event) : void {
		if ($event->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR or PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
			if ($event->getPlayer()->getInventory()->getItemInHand() instanceof MushroomStew) {
				$event->getPlayer()->getInventory()->setItemInHand(Item::get(ItemIds::BOWL, 0, 1));
				$event->getPlayer()->setHealth($event->getPlayer()->getHealth() + 6);
				return;
			}
		}
		if ($this->plugin->classes[$event->getPlayer()->getName()] == "idling") {
			if (isset($this->plugin->waitingcd[$event->getPlayer()->getName()]) and time() - $this->plugin->waitingcd[$event->getPlayer()->getName()] < 1) return;
			switch ($event->getItem()->getCustomName()) {
				case "§r§fClaim Last Kit":
					switch ($this->plugin->lastkit[$event->getPlayer()->getName()]) {
						case "pvp":
							$this->plugin::getClassManager()->setPvpClass($event->getPlayer());
							break;
						case "ninja":
							$this->plugin::getClassManager()->setNinjaClass($event->getPlayer());
							break;
						case "tank":
							$this->plugin::getClassManager()->setTankClass($event->getPlayer());
							break;
						case "archer":
							$this->plugin::getClassManager()->setArcherClass($event->getPlayer());
							break;
						case "launcher":
							$this->plugin::getClassManager()->setLauncherClass($event->getPlayer());
							break;
						default:
							$event->getPlayer()->sendMessage("§cYou Have Not Yet Claimed a Kit In Your Current Session.");
							break;

					}
					break;
				case "§r§fOpen Shop":
					$this->plugin::getUtils()->quickCheck($event->getPlayer());
					$this->plugin::getUiManager()->openUi($event->getPlayer(), "classes");
					break;
			}
			$this->plugin->waitingcd[$event->getPlayer()->getName()] = time();
		}
	}

	public function onConsume(PlayerItemConsumeEvent $event) {
		$event->setCancelled(true);
	}

	public function onRespawn(PlayerRespawnEvent $event) : void {
		$event->getPlayer()->teleport($event->getPlayer()->getLevel()->getSafeSpawn());
		$this->plugin::getClassManager()->setIdlingClass($event->getPlayer());
	}


	/**
	 * @param PlayerExhaustEvent $event
	 */
	public function onHungry(PlayerExhaustEvent $event) : void {
		$event->setCancelled(true);
	}

}