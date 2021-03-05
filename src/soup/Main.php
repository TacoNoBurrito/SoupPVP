<?php
namespace soup;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\entity\Entity;
use pocketmine\item\ItemFactory;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use soup\anticheat\AnticheatListener;
use soup\classes\ClassListener;
use soup\classes\ClassManager;
use soup\classes\ClassShopManager;
use soup\classes\ClassTask;
use soup\commands\ForceClassCommand;
use soup\commands\KickCommand;
use soup\commands\PingCommand;
use soup\commands\SetRankCommand;
use soup\entity\FishHook;
use soup\items\FishingRod;
use soup\tasks\AnnouncementTask;
use soup\tasks\ClearEntitesTask;
use soup\tasks\FloatingTextTask;
use soup\tasks\ScoreboardTask;
use soup\ui\UIManager;
use soup\utils\Utilities;

class Main extends PluginBase {

	public $playerdata;
	public $purchasedata;
	public $abilitydata;

	public $classes = [];

	protected static $classmanager;
	protected static $classShopManager;
	protected static $uiManager;
	protected static $utils;
	protected static $instance;

	public $lasthit = [];

	public $lastkit = [];

	public $ninjacooldown;

	public $waitingcd;
	public $launchercooldown;
	public $freezercooldown;

	public $os;

	public $leaderBoard;

	public $fishing = [];

	public function onEnable() : void {
		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}
		self::$instance = $this;
		self::$classmanager = new ClassManager($this);
		self::$classShopManager = new ClassShopManager($this);
		self::$uiManager = new UIManager($this);
		self::$utils = new Utilities($this);
		$this->playerdata = new Config($this->getDataFolder() . "players.yml", Config::YAML);
		$this->purchasedata = new Config($this->getDataFolder() . "purchases.yml", Config::YAML);
		$this->abilitydata = new Config($this->getDataFolder() . "abilities.yml", Config::YAML);
		$this->getScheduler()->scheduleRepeatingTask(new ScoreboardTask($this), 60);
		$this->getScheduler()->scheduleRepeatingTask(new ClassTask($this), 60);
		$this->getScheduler()->scheduleRepeatingTask(new ClearEntitesTask($this), 30 * 20);
		$this->getServer()->getPluginManager()->registerEvents(new AnticheatListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new ClassListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->getServer()->getCommandMap()->register("setrank", new SetRankCommand($this));
		$this->getServer()->getCommandMap()->register("ping", new PingCommand($this));
		$this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand("kick"));
		$this->getServer()->getCommandMap()->register("kick", new KickCommand($this));
		$this->getServer()->getCommandMap()->register("forceclass", new ForceClassCommand($this));
		$this->leaderBoard = new FloatingTextParticle(new Vector3(229,25,197), "");
		$this->getServer()->getDefaultLevel()->addParticle($this->leaderBoard);
		$this->getScheduler()->scheduleRepeatingTask(new AnnouncementTask($this), 20);
		$this->getScheduler()->scheduleRepeatingTask(new FloatingTextTask($this), 20 * 20);
		Entity::registerEntity(FishHook::class, false, ["FishingHook", "minecraft:fishing_rod"]);
		ItemFactory::registerItem(new FishingRod(), true);
	}

	/**
	 * Cool Leaderboards System
	 * TODO: Make a better data storing method so i dont have to use this crappy laggy leaderboards code.
	 */
	public function getKillsLeaderboard() : string {
		$array = [];
		for ($i=0;$i<count($this->playerdata->getAll());$i++) {
			$b = $this->playerdata->getAll(true)[$i];
			if (empty($this->playerdata->get($b)["kills"])) continue;
			$array[$this->playerdata->getAll(true)[$i]] = $this->playerdata->get($b)["kills"];
		}
		arsort($array);
		$string = "§eTop Kills Overall.\n";
		$num = 1;
		foreach($array as $name => $kills) {
			if ($num > 10) break;
			$string .= "§7{$num}§e. {$name}§7: §6{$kills}\n";
			$num++;
		}
		return $string;
	}

	public function getBestOnlineKills() : string {
		$array = [];
		$string = "§eTop Online Overall Kills.\n";
		foreach($this->getServer()->getOnlinePlayers() as $player) {
			if(empty($this->playerdata->getNested($player->getName().".kills"))) {
				break;
			}
			$array[$player->getName()] = $this->playerdata->getNested($player->getName().".kills");
		}
		arsort($array);
		$num = 1;
		foreach($array as $name => $kills) {
			$string .= "§7{$num}§e. {$name}§7: §6{$kills}\n";
			$num++;
		}
		return $string;
	}

	public function sendMessageToStaff(string $message) : void {
		foreach($this->getServer()->getOnlinePlayers() as $player) {
			$ranks = ["mod", "manager", "owner"];
			if (in_array($this->playerdata->get($player->getName())["rank"], $ranks)) {
				$player->sendMessage($message);
			}
		}
	}

	public static function getInstance() : self {
		return self::$instance;
	}

	public function getClass($player) {
		return $this->classes[$player->getName()];
	}

	public static function getClassManager() : ClassManager {
		return self::$classmanager;
	}

	public static function getClassShopManager() : ClassShopManager {
		return self::$classShopManager;
	}

	public static function getUiManager() : UIManager {
		return self::$uiManager;
	}

	public static function getUtils() : Utilities {
		return self::$utils;
	}

	public function startFishing($obj,$player):void{
		if($player->isOnline()){
			if(!$this->isFishing($player)){
				$this->fishing[$player->getName()] = "s";
			}
		}
	}

	public function getFishing(){
		return $this->fishing;
	}

	public function stopFishing($player,bool $click=true, bool $killEntity=true):void{
		if($this->isFishing($player)){
			unset($this->fishing[$player->getName()]);
		}
	}

	public function isFishing($player) : bool {
		return in_array($player->getName(), $this->fishing);
	}

}