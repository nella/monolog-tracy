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

class InvalidLogDirectoryException extends \LogicException implements \Nella\MonologTracy\Tracy\Exception
{

	/** @var string */
	private $logDirectory;

	/**
	 * @param string $logDirectory
	 * @param \Exception|NULL $previous
	 */
	public function __construct($logDirectory, \Exception $previous = NULL)
	{
		parent::__construct(sprintf(
			'Tracy log directory "%s" not found or is not a directory.',
			$logDirectory
		), 0, $previous);

		$this->logDirectory;
	}

	/**
	 * @codeCoverageIgnore
	 * @return string
	 */
	public function getLogDirectory()
	{
		return $this->logDirectory;
	}

}
