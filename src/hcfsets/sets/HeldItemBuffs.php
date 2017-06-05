<?php

/**
 *
 * HCFSets – HeldItemBuffs.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\sets;

use pocketmine\entity\Effect;
use pocketmine\item\Item;
use pocketmine\Player;

class HeldItemBuffs extends BuffEffectSet {

	/**
	 * Apply the buffs to a player
	 *
	 * @param Player $player
	 *
	 * @return bool
	 */
	public function applyBuffs(Player $player) : bool {
		if(isset($this->effects[$id = $player->getItemInHand()->getId()])) {
			$player->addEffect(clone $this->effects[$id]);
			return true;
		}
		return false;
	}

	/**
	 * Read buff data from config and parse effects into an array
	 *
	 * @param array $data
	 */
	protected function parseEffects(array $data) {
		foreach($data as $item => $buffData) {
			if(($item = Item::fromString($item)) instanceof Item) {
				foreach($buffData as $effectData) {
					$this->effects[$item->getId()] = Effect::getEffectByName($effectData["id"])->setAmplifier($effectData["amplifier"]);
				}
			} else {
				$this->getSet()->getManager()->getPlugin()->getLogger()->warning("Couldn't load held item buffs for item named '{$item}' in '{$this->getSet()->getDisplayName()}' set!");
			}
		}
	}

}