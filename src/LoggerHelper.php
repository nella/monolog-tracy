<?php
/**
 * This file is part of the Nella Project (https://monolog-tracy.nella.io).
 *
 * Copyright (c) Patrik Votoček (http://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\MonologTracy;

use Tracy\BlueScreen;

class LoggerHelper extends \Tracy\Logger
{

	/**
	 * @param string $directory
	 * @param BlueScreen $blueScreen
	 */
	public function __construct($directory, BlueScreen $blueScreen)
	{
		$logDirectoryRealPath = realpath($directory);
		if ($logDirectoryRealPath === FALSE || !is_dir($directory)) {
			throw new \Nella\MonologTracy\InvalidLogDirectoryException(sprintf(
				'Tracy log directory "%s" not found or is not a directory.',
				$directory
			));
		}

		parent::__construct($logDirectoryRealPath, NULL, $blueScreen);
	}

	/**
	 * @param \Exception|\Throwable $exception
	 * @return string file path
	 */
	public function renderToFile($exception)
	{
		return $this->logException($exception);
	}

	/**
	 * @deprecated
	 * @param string $message
	 * @param string $priority
	 */
	public function log($message, $priority = self::INFO)
	{
		throw new \Nella\MonologTracy\NotSupportedException('LoggerHelper::log is not supported.');
	}

	/**
	 * @deprecated
	 * @param string $message
	 */
	protected function formatMessage($message)
	{
		throw new \Nella\MonologTracy\NotSupportedException('LoggerHelper::formatMessage is not supported.');
	}

	/**
	 * @deprecated
	 * @param string $message
	 * @param string|NULL $exceptionFile
	 */
	protected function formatLogLine($message, $exceptionFile = NULL)
	{
		throw new \Nella\MonologTracy\NotSupportedException('LoggerHelper::formatLogLine is not supported.');
	}

	/**
	 * @deprecated
	 * @param string $message
	 */
	protected function sendEmail($message)
	{
		throw new \Nella\MonologTracy\NotSupportedException('LoggerHelper::sendEmail is not supported.');
	}

	/**
	 * @deprecated
	 * @param string $message
	 * @param string $email
	 */
	public function defaultMailer($message, $email)
	{
		throw new \Nella\MonologTracy\NotSupportedException('LoggerHelper::defaultMailer is not supported.');
	}

}
