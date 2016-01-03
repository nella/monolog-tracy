<?php
/**
 * This file is part of the Nella Project (https://monolog-tracy.nella.io).
 *
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\MonologTracy\Tracy;

class PanelIsNotCallableException extends \InvalidArgumentException implements \Nella\MonologTracy\Tracy\Exception
{

	/**
	 * @param \Exception|NULL $previous
	 */
	public function __construct(\Exception $previous = NULL)
	{
		parent::__construct('Panel is not callable.', 0, $previous);
	}

}
