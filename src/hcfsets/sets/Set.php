<?php

/**
 *
 * HCFSets – Set.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\sets;

use hcfsets\session\PlayerSession;
use hcfsets\utils\Utils;
use pocketmine\Player;

class Set {

	/** @var SetManager */
	private $manager = null;

	private $displayName = "";

	/** @var ArmorSet */
	private $armor = null;

	/** @var BuffEffectSet */
	private $buffs = null;

	/** @var HeldItemBuffs */
	private $heldBuffs = null;

	/** @var bool */
	private $closed = false;

	public function __construct(SetManager $manager, array $data) {
		$this->manager = $manager;
		$this->parse($data);
	}

	public function getManager() : SetManager {
		return $this->manager;
	}

	public function getDisplayName() : string {
		return $this->displayName;
	}

	public function getArmorSet() : ArmorSet {
		return $this->armor;
	}

	public function getBuffs() : BuffEffectSet {
		return $this->buffs;
	}

	public function getHeldItemBuffs() : HeldItemBuffs {
		return $this->heldBuffs;
	}

	/**
	 * Check if a player has the correct armor to activate a set
	 *
	 * @param array $armor
	 *
	 * @return bool
	 */
	public function matchesSet($armor) : bool {
		return $this->armor->isValidHelmet($armor[0]) and $this->armor->isValidChestplate($armor[1]) and $this->armor->isValidLeggings($armor[2]) and $this->armor->isValidBoots($armor[3]);
	}

	/**
	 * Applies the set to a player
	 *
	 * @param Player $player
	 */
	public function applyTo(Player $player) {
		$this->buffs->applyBuffs($player);
	}

	public function tickFor(PlayerSession $session) {
		$this->buffs->applyBuffs($player = $session->getOwner());
		if($session->hasActiveItemBuff()) {
			if(!($value = $this->heldBuffs->applyBuffs($player))) {
				$session->setHasActiveItemBuff($value);
				$this->heldBuffs->removeBuffs($player);
			}
		}
	}

	/**
	 * Removes the set from a player
	 *
	 * @param Player $player
	 */
	public function removeFrom(Player $player) {
		$this->buffs->removeBuffs($player);
	}

	public function close() {
		if(!$this->closed) {
			$this->closed = true;
			$this->armor->close();
			unset($this->manager, $this->armor);
		}
	}

	protected function parse(array $data) {
		$this->displayName = Utils::translateColors($data["display"]);
		$this->armor = new ArmorSet($this, $data["armor"]);
		$this->buffs = new BuffEffectSet($this, $data["buffs"]);
		$this->heldBuffs = new HeldItemBuffs($this, $data["held-item-buffs"]);
	}

}