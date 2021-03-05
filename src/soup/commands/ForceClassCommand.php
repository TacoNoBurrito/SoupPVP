<?php
namespace soup\commands;
use pocketmine\Player;
use soup\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
class ForceClassCommand extends PluginCommand {
	private $plugin;
	public function __construct(Main $plugin) {
		parent::__construct("forceclass", $plugin);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if ($sender instanceof Player) return;
		if (empty($args[0])) {
			$sender->sendMessage("Usage: /forceclass (player) (class)");
			return;
		}
		if (empty($args[1])) {
			$sender->sendMessage("Usage: /forceclass (player) (class)");
			return;
		}
		$player = $this->plugin->getServer()->getPlayer($args[0]);
		if ($player == null) {
			$sender->sendMessage("Player Is Null.");
			return;
		}
		$this->plugin->classes[$player->getName()] = $args[1];
	}
}