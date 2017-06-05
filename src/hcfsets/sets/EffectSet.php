<?php

/**
 *
 * HCFSets – EffectSet.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\sets;

use pocketmine\entity\Effect;

abstract class EffectSet {

	/** @var Effect[] */
	protected $effects = [];
	/** @var Set */
	private $set = null;

	public function __construct(Set $set, array $data) {
		$this->set = $set;
		$this->parseEffects($data);
	}

	public function getSet() : Set {
		return $this->set;
	}

	/**
	 * @return Effect[]
	 */
	public function getEffects() {
		return $this->effects;
	}

	protected abstract function parseEffects(array $data);

}