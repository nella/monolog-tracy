<?php

namespace Nella\MonologTracy\Handler;

use Monolog\Logger;

class BlueScreenHandlerTest extends \Nella\MonologTracy\TestCase
{

	/** @var string */
	private $logDirectory;

	/** @var BlueScreenHandler */
	private $handler;

	public function setup()
	{
		$logDirectory = sys_get_temp_dir() . '/' . getmypid() . microtime() . '-blueScreenHandlerTest';
		@rmdir($logDirectory); // directory may not exist
		if (@mkdir($logDirectory) === FALSE && !is_dir($logDirectory)) {
			$this->fail(sprintf('Temp directory "%s" could not be created.', $logDirectory));
		}
		$this->logDirectory = $logDirectory;

		$blueScreen = new \Tracy\BlueScreen();
		$this->handler = new BlueScreenHandler($blueScreen, $logDirectory);
	}

	public function testSkipsInvalidException()
	{
		$record = $this->createRecord($exception = 'Something weird is happening.');
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

		$hash = $this->handler->getExceptionHash($exception);
		$file = $this->logDirectory . '/exception-2012-12-21-00-00-00-' . $hash . '.html';

		$this->assertTrue(is_file($file));
	}

	public function testDoesNotSaveTwice()
	{
		// Save first
		$record = $this->createRecord(new \Exception('message'));
		$this->handler->handle($record);

		// Handle  second
		$record = $this->createRecord($exception = new \Exception('message'));
		$record['datetime']->modify('+ 42 minutes');

		$hash = $this->handler->getExceptionHash($exception);
		$file = $this->logDirectory . '/exception-2012-12-21-00-42-00-' . $hash . '.html';

		$this->assertFalse(is_file($file));
		$this->assertSame(1, $this->countExceptionFiles());
	}

	private function countExceptionFiles()
	{
		$directory = new \DirectoryIterator($this->logDirectory);
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
			'datetime' => new \DateTime('2012-12-21 00:00:00', new \DateTimeZone('UTC')),
			'extra' => [],
		];
	}

}
