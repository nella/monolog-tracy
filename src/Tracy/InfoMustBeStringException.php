<?php
/**
 * This file is part of the Nella Project (https://monolog-tracy.nella.io).
 *
 * Copyright (c) Patrik Votoček (http://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\MonologTracy\Tracy;

class InfoMustBeStringException extends \InvalidArgumentException implements \Nella\MonologTracy\Tracy\Exception
{

	/**
	 * @param string $givenType
	 * @param \Exception|NULL $previous
	 */
	public function __construct($givenType, \Exception $previous = NULL)
	{
		parent::__construct(sprintf(
			'Info must be string "%s" given,',
			$givenType
		), 0, $previous);
	}

}
