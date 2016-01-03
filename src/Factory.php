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
use Nella\MonologTracy\Tracy\BlueScreenFactory;
use Nella\MonologTracy\Tracy\LoggerHelper;
use Tracy\BlueScreen;

/**
 * @deprecated
 */
class Factory
{

	/**
	 * @param string[] $info
	 * @return BlueScreen
	 */
	public static function blueScreen(array $info = [])
	{
		return static::blueScreenFactory($info)->create();
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
		$loggerHelper = static::loggerHelper($logDirectory, $blueScreen);
		return new BlueScreenHandler($loggerHelper, $level, $bubble);
	}

	/**
	 * @param string[] $info
	 * @return BlueScreenFactory
	 */
	private static function blueScreenFactory(array $info = [])
	{
		$factory = new BlueScreenFactory();
		foreach ($info as $item) {
			$factory->registerInfo($item);
		}
		return $factory;
	}

	/**
	 * @param string $logDirectory
	 * @param BlueScreen $blueScreen
	 * @return LoggerHelper
	 */
	private static function loggerHelper($logDirectory, BlueScreen $blueScreen)
	{
		return new LoggerHelper($logDirectory, $blueScreen);
	}

}
