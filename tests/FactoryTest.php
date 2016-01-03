<?php

namespace Nella\Monolog;

class BlueScreenFactoryTest extends \Nella\Monolog\TestCase
{

	public function testBlueScreen()
	{
		$blueScreen = Factory::blueScreen();
		$this->assertInstanceOf('Tracy\BlueScreen', $blueScreen);
	}

	public function testBlueScreenHandler()
	{
		$handler = Factory::blueScreenHandler(__DIR__);
		$this->assertInstanceOf('Nella\Monolog\Handler\BlueScreenHandler', $handler);
	}

}
