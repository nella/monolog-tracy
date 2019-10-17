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

use DateTimeImmutable;
use DateTimeInterface;
use Tracy\BlueScreen;

class LoggerHelper extends \Tracy\Logger
{

	/**
	 * @param string $directory
	 * @param BlueScreen $blueScreen
	 */
	public function __construct($directory, BlueScreen $blueScreen)
	{
		if (!is_dir($directory)) {
			if (!@mkdir($directory, 0777, TRUE) && !is_dir($directory)) {
				throw new \Nella\MonologTracy\Tracy\LogDirectoryCouldNotBeCreatedException(sprintf(
					'Tracy log Directory "%s" could not be created.',
					$directory
				));
			}
		}

		$logDirectoryRealPath = realpath($directory);
		parent::__construct($logDirectoryRealPath, NULL, $blueScreen);
	}

	/**
	 * @param \Exception|\Throwable $exception
	 * @param DateTimeInterface $datetime
	 * @return string file path
	 */
	public function renderToFile($exception, DateTimeInterface $datetime = NULL)
	{
		return $this->logException($exception, $this->getExceptionFile($exception));
	}

	/**
	 * @param \Exception|\Throwable $exception
	 * @return string
	 */
	public function getExceptionHash($exception)
	{
		$tracyExceptionFilePath = parent::getExceptionFile($exception);
		$matches = [];
		preg_match('~^.*--(?P<hash>[a-fA-F0-9]+).html$~', $tracyExceptionFilePath, $matches);
		if (!isset($matches['hash'])) {
			// @codeCoverageIgnoreStart
			// not testable since it would be eventually coming from parent
			throw new \Nella\MonologTracy\Tracy\NotSupportedException('Non-compatible exception file name -> unexpected Tracy version.');
		}
		// @codeCoverageIgnoreEnd

		return $matches['hash'];
	}

	/**
	 * @param \Exception|\Throwable $exception
	 * @return string
	 */
	public function formatExceptionFilePath($exception)
	{
		$dir = strtr($this->directory . '/', '\\/', DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR);
		$hash = $this->getExceptionHash($exception);
		foreach (new \DirectoryIterator($this->directory) as $file) {
			if (strpos($file, $hash)) {
				return $dir . $file;
			}
		}
		return $dir . 'exception--' . (new DateTimeImmutable())->format('Y-m-d--H-i-s') . '--' . $hash . '.html';
	}

	/**
	 * @deprecated
	 * @param \Exception|\Throwable $exception
	 * @param string $level
	 * @return string
	 */
	public function getExceptionFile(\Throwable $exception, string $level = self::EXCEPTION): string
	{
		return $this->formatExceptionFilePath($exception);
	}

	/**
	 * @deprecated
	 * @param string $message
	 * @param string $priority
	 */
	public function log($message, $priority = self::INFO)
	{
		throw new \Nella\MonologTracy\Tracy\NotSupportedException('LoggerHelper::log is not supported.');
	}

	/**
	 * @codeCoverageIgnore
	 * @deprecated
	 * @param string $message
	 */
	public static function formatMessage($message): string
	{
		throw new \Nella\MonologTracy\Tracy\NotSupportedException('LoggerHelper::formatMessage is not supported.');
	}

	/**
	 * @codeCoverageIgnore
	 * @deprecated
	 * @param string $message
	 * @param string|NULL $exceptionFile
	 */
	public static function formatLogLine($message, string $exceptionFile = NULL): string
	{
		throw new \Nella\MonologTracy\Tracy\NotSupportedException('LoggerHelper::formatLogLine is not supported.');
	}

	/**
	 * @codeCoverageIgnore
	 * @deprecated
	 * @param string $message
	 */
	protected function sendEmail($message): void
	{
		throw new \Nella\MonologTracy\Tracy\NotSupportedException('LoggerHelper::sendEmail is not supported.');
	}

}
