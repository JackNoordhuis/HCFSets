<?php

/**
 *
 * HCFSets – PlayerSession.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\session;

use hcfsets\sets\Set;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class PlayerSession {

	/** @var SessionManager */
	private $manager = null;

	/** @var Player */
	private $owner;

	/** @var Set|null */
	private $activeSet = null;

	/** @var bool */
	private $hasActiveItemBuff = false;

	public function __construct(SessionManager $manager, Player $owner) {
		$this->manager = $manager;
		$this->owner = $owner;
	}

	public function getManager() : SessionManager {
		return $this->manager;
	}

	public function getOwner() : Player {
		return $this->owner;
	}

	public function ownerIsValid() : bool {
		return $this->owner instanceof Player and $this->owner->isOnline() and $this->owner->isAlive();
	}

	public function hasActiveItemBuff() : bool {
		return $this->hasActiveItemBuff;
	}

	/**
	 * @param bool $value
	 */
	public function setHasActiveItemBuff(bool $value = true) {
		$this->hasActiveItemBuff = $value;
	}

	public function tick($tick) {
		if($this->ownerIsValid() and $this->hasActiveSet()) {
			$this->activeSet->tickFor($this);
			return true;
		}
		return false;
	}

	/**
	 * @return Set|null
	 */
	public function getSet() {
		return $this->activeSet;
	}

	public function checkSet(Item $item) {
		if($this->ownerIsValid()) {
			$armor = $this->owner->getInventory()->getArmorContents();
			$armor[($item->isHelmet() ? 0 : $item->isChestplate() ? 1 : $item->isLeggings() ? 2 : $item->isBoots() ? 3 : 0)] = $item;
			if($this->hasActiveSet() and $this->activeSet->matchesSet($armor)) return true;
			echo "Looking for a matching set...\n";
			if(($set = $this->manager->getPlugin()->getSetManager()->findValidSet($this->owner, $armor)) instanceof Set) {
				$set->applyTo($this->owner);
				$this->activeSet = $set;
				$this->owner->sendMessage("Activated the {$set->getDisplayName()}" . TextFormat::RESET . " set!");
			} else {
				if($this->hasActiveSet()) {
					$this->activeSet->removeFrom($this->owner);
					$this->owner->sendMessage("Deactivated the {$this->activeSet->getDisplayName()}" . TextFormat::RESET . " set!");
					$this->activeSet = null;
				}
			}
			var_dump($armor);
			return true;
		}
		return false;
	}

	public function hasActiveSet() : bool {
		return $this->activeSet instanceof Set;
	}

	public function removeSet() {
		$this->activeSet = null;
	}

}