<?php

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
