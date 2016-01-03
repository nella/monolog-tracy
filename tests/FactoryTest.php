<?php

namespace Nella\MonologTracy;

class FactoryTest extends \Nella\MonologTracy\TestCase
{

	public function testBlueScreen()
	{
		$blueScreen = Factory::blueScreen();
		$this->assertInstanceOf('Tracy\BlueScreen', $blueScreen);
	}

	public function testBlueScreenHandler()
	{
		$handler = Factory::blueScreenHandler(__DIR__);
		$this->assertInstanceOf('Nella\MonologTracy\Handler\BlueScreenHandler', $handler);
	}

}
