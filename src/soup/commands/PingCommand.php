<?php
namespace soup\commands;
use pocketmine\Player;
use soup\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
class PingCommand extends PluginCommand {
	private $plugin;
	public function __construct(Main $plugin) {
		parent::__construct("ping", $plugin);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(empty($args[0])) {
			$sender->sendMessage("§aYour Ping: §c".$sender->getPing().".");
			return true;
		} else {
			$player = $this->plugin->getServer()->getPlayer($args[0]);
			if (!$player) {
				$sender->sendMessage("§cThis Player Is Not Online, Or Doesnt Exist.");
				return true;
			}
			$sender->sendMessage("§a".$player->getName()."'s Ping Is §c".$player->getPing().".");
		}
		return;
	}
}