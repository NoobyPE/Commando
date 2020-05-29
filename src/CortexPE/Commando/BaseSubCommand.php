<?php

/***
 *    ___                                          _
 *   / __\___  _ __ ___  _ __ ___   __ _ _ __   __| | ___
 *  / /  / _ \| '_ ` _ \| '_ ` _ \ / _` | '_ \ / _` |/ _ \
 * / /__| (_) | | | | | | | | | | | (_| | | | | (_| | (_) |
 * \____/\___/|_| |_| |_|_| |_| |_|\__,_|_| |_|\__,_|\___/
 *
 * Commando - A Command Framework virion for PocketMine-MP
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * Written by @CortexPE <https://CortexPE.xyz>
 *
 */
declare(strict_types=1);

namespace CortexPE\Commando;

abstract class BaseSubCommand extends BaseCommand{
	/** @var BaseCommand */
	protected $parent;

	public function getParent(): ?BaseCommand {
		return $this->parent;
	}

	/**
	 * @param BaseCommand $parent
	 *
	 * @internal Used to pass the parent context from the parent command
	 */
	public function setParent(BaseCommand $parent): void {
		$this->parent = $parent;
	}

	/**
	 * Just recalculate this each time for SubCommands..
	 * A stupid hack to fix broken usage messages.
	 * Got a better way? PR please :)
	 *
	 * @return string
	 */
	public function getUsage(): string{
		$parent = $this->parent;
		$parentNames = "";

		while($parent instanceof BaseSubCommand) {
			$parentNames = $parent->getName() . "" . $parentNames;
			$parent = $parent->getParent();
		}

		if($parent instanceof BaseCommand){
			$parentNames = $parent->getName() . " " . $parentNames;
		}

		return $this->generateUsageMessage(trim($parentNames));
	}
}