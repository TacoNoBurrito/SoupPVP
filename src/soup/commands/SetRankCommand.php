<?php
namespace soup\commands;
use pocketmine\Player;
use soup\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
class SetRankCommand extends PluginCommand {
	private $plugin;
	public function __construct(Main $plugin) {
		parent::__construct("setrank", $plugin);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if ($sender instanceof Player) return;
		if (empty($args[0])) return;
		if (empty($args[1])) return;
		$this->plugin->playerdata->setNested($args[0].".rank", $args[1]);
		return;
	}
}