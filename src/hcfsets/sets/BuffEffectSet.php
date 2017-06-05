<?php

/**
 *
 * HCFSets – BuffEffectSet.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\sets;

use pocketmine\entity\Effect;
use pocketmine\Player;

class BuffEffectSet extends EffectSet {

	/**
	 * Apply the buffs to a player
	 *
	 * @param Player $player
	 */
	public function applyBuffs(Player $player) {
		foreach($this->effects as $e) {
			$effect = clone $e;
			$player->addEffect($effect->setDuration(20 * 30));
		}
	}

	/**
	 * Remove all buffs from a player
	 *
	 * @param Player $player
	 */
	public function removeBuffs(Player $player) {
		foreach($this->effects as $e) {
			$player->removeEffect($e->getId());
		}
	}

	/**
	 * Read buff data from config and parse effects into an array
	 *
	 * @param array $data
	 */
	protected function parseEffects(array $data) {
		for($i = 0; $i < count($data); $i++) {
			$this->effects[] = Effect::getEffectByName($data[$i]["id"])->setAmplifier($data[$i]["amplifier"])->setDuration(20 * 30);
		}
	}

}