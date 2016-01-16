<?php
/**
 * This file is part of the Nella Project (https://monolog-tracy.nella.io).
 *
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\MonologTracy;

use Monolog\Logger;
use Nella\MonologTracy\Tracy\LoggerHelper;

class BlueScreenHandlerTest extends \Nella\MonologTracy\TestCase
{

	/** @var BlueScreenHandler */
	private $handler;

	/** @var LoggerHelper */
	private $loggerHelper;

	public function setup()
	{
		$logDirectory = sys_get_temp_dir() . '/' . getmypid() . microtime() . '-blueScreenHandlerTest';
		@rmdir($logDirectory); // directory may not exist
		if (@mkdir($logDirectory) === FALSE && !is_dir($logDirectory)) {
			$this->fail(sprintf('Temp directory "%s" could not be created.', $logDirectory));
		}

		$blueScreen = new \Tracy\BlueScreen();
		$this->loggerHelper = new LoggerHelper($logDirectory, $blueScreen);
		$this->handler = new BlueScreenHandler($this->loggerHelper);
	}

	public function testSkipsInvalidException()
	{
		$record = $this->createRecord('Something weird is happening.');
		$this->handler->handle($record);

		$this->assertSame(0, $this->countExceptionFiles());
	}

	public function testSkipsEmptyException()
	{
		$record = $this->createRecord();
		unset($record['context']['exception']);
		$this->handler->handle($record);

		$this->assertSame(0, $this->countExceptionFiles());
	}

	public function testSaveException()
	{
		$record = $this->createRecord($exception = new \Exception());
		$this->handler->handle($record);

		$this->assertFileExists($this->loggerHelper->getExceptionFile($exception, $record['datetime']));
		$this->assertSame(1, $this->countExceptionFiles());
	}

	public function testDoesNotSaveTwice()
	{
		// Save first
		$record = $this->createRecord($exception = new \Exception('message'));
		$this->handler->handle($record);
		$datetime = $record['datetime'];

		// Handle  second
		$record = $this->createRecord($exception);
		$record['datetime']->modify('+ 42 minutes');
		$this->handler->handle($record);

		$this->assertFileExists($this->loggerHelper->getExceptionFile($exception, $datetime));
		$this->assertSame(1, $this->countExceptionFiles());
	}

	private function countExceptionFiles()
	{
		$directory = new \DirectoryIterator($this->loggerHelper->directory);
		return (iterator_count($directory) - 2); // minus dotfiles
	}

	/**
	 * @param \Exception $exception
	 * @param int $level
	 * @return array
	 */
	private function createRecord($exception = NULL, $level = Logger::CRITICAL)
	{
		return [
			'message' => 'record',
			'context' => [
				'exception' => $exception,
			],
			'level' => $level,
			'level_name' => Logger::getLevelName($level),
			'channel' => 'test',
			'datetime' => new \DateTimeImmutable('2012-12-21 00:00:00', new \DateTimeZone('UTC')),
			'extra' => [],
		];
	}

}
