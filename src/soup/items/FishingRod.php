<?php

declare(strict_types=1);

namespace soup\items;

use pocketmine\entity\Entity;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AnimatePacket;
use pocketmine\Player;
use soup\Main;

class FishingRod extends Durable{

	public function __construct($meta=0){
		parent::__construct(Item::FISHING_ROD, $meta, "Fishing Rod");
	}
	public function getMaxStackSize():int{
		return 1;
	}
	public function getCooldownTicks():int{
		return 5;
	}
	public function getMaxDurability():int{
		return 355;
	}
	public function onClickAir(Player $player, Vector3 $directionVector):bool{
		if(!$player->hasItemCooldown($this)){
			$player->resetItemCooldown($this);
			if(!Main::getInstance()->isFishing($player)){
				$motion=$player->getDirectionVector();
				$motion=$motion->multiply(0.4);
				$nbt=Entity::createBaseNBT($player->add(0, $player->getEyeHeight(), 0), $motion);
				$hook=Entity::createEntity("FishingHook", $player->level, $nbt, $player);
				$hook->spawnToAll();
			}else{
				$hook=Main::getInstance()->isFishing($player);
				if(!is_null($hook)) $hook->flagForDespawn();
				Main::getInstance()->stopFishing($player);
			}
			$player->broadcastEntityEvent(AnimatePacket::ACTION_SWING_ARM);
			return true;
		}
		return false;
	}
	public function getProjectileEntityType():string{
		return "Hook";
	}
	public function getThrowForce():float{
		return 0.9;
	}
}