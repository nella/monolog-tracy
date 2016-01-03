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

use Tracy\BlueScreen;

class FactoryTest extends \Nella\MonologTracy\TestCase
{

	public function testBlueScreen()
	{
		$blueScreen = Factory::blueScreen(['Test']);
		$this->assertInstanceOf(BlueScreen::class, $blueScreen);
	}

	public function testBlueScreenHandler()
	{
		$handler = Factory::blueScreenHandler(__DIR__);
		$this->assertInstanceOf(BlueScreenHandler::class, $handler);
	}

}
