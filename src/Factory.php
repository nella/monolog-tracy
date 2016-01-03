<?php

/**
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 */

namespace Nella\MonologTracy;

use Monolog\Logger;
use Nella\MonologTracy\Tracy\LoggerHelper;
use Tracy\BlueScreen;
use Tracy\Debugger;

class Factory
{

	/**
	 * @param array $info
	 * @return BlueScreen
	 */
	public static function blueScreen(array $info = [])
	{
		$blueScreen = new BlueScreen();
		$blueScreen->info = array_merge([
			'PHP ' . PHP_VERSION,
			isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : NULL,
			'Tracy ' . Debugger::VERSION,
		], $info);
		return $blueScreen;
	}

	/**
	 * @param string $logDirectory
	 * @param int $level
	 * @param bool $bubble
	 * @param BlueScreen $blueScreen
	 * @return BlueScreenHandler
	 */
	public static function blueScreenHandler($logDirectory, $level = Logger::DEBUG, $bubble = TRUE, BlueScreen $blueScreen = NULL)
	{
		$blueScreen = $blueScreen !== NULL ? $blueScreen : static::blueScreen();
		$loggerHelper = new LoggerHelper($logDirectory, $blueScreen);
		return new BlueScreenHandler($loggerHelper, $level, $bubble);
	}

}
