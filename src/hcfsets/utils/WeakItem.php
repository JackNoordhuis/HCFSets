<?php

/**
 *
 * HCFSets – WeakItem.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\utils;

use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;

class WeakItem {

	/** @var int */
	private $id = Item::AIR;

	/** @var int */
	private $damage = 0;

	/** @var int */
	private $amount = 1;

	/** @var CompoundTag */
	private $nbt = null;

	/**
	 * WeakItem constructor.
	 *
	 * @param int $id
	 * @param int $damage
	 * @param int $amount
	 * @param string $nbt
	 */
	public function __construct(int $id, int $damage = 0, int $amount = 1, $nbt = "") {
		$this->id = $id;
		$this->damage = $damage;
		$this->amount = $amount;
		$this->nbt = $nbt;
	}

	public function getItem() : Item {
		return Item::get($this->id, $this->damage, $this->amount, $this->nbt);
	}

	/**
	 * @param Item $item
	 * @param bool $checkId
	 * @param bool $checkDamage
	 * @param bool $checkAmount
	 * @param bool $checkTag
	 *
	 * @return bool
	 */
	public function deepEqualsItem(Item $item, $checkId = true, $checkDamage = true, $checkAmount = true, $checkTag = true) {
		if($checkId and $this->id !== $item->getId())
			return false;
		if($checkDamage and $this->damage !== $item->getDamage())
			return false;
		if($checkAmount and $this->amount !== $item->getCount())
			return false;
		return true;
	}

}