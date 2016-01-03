<?php
/**
 * This file is part of the Nella Project (https://monolog-tracy.nella.io).
 *
 * Copyright (c) Patrik Votoček (http://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\MonologTracy\Tracy;

use Tracy\BlueScreen;

class BlueScreenFactoryTest extends \Nella\MonologTracy\TestCase
{

	/** @var BlueScreenFactory */
	private $factory;

	public function setUp()
	{
		parent::setUp();

		$this->factory = new BlueScreenFactory();
	}

	/**
	 * @expectedException \Nella\MonologTracy\Tracy\InfoMustBeStringException
	 */
	public function testRegisterInvalidInfo()
	{
		$this->factory->registerInfo(NULL);
	}

	public function testRegisterInfo()
	{
		$this->factory->registerInfo('Test');
		$blueScreen = $this->factory->create();

		$this->assertInstanceOf(BlueScreen::class, $blueScreen);
		$this->assertTrue(in_array('Test', $blueScreen->info, TRUE));
	}

	public function testRegisterInfoMultiple()
	{
		$this->factory->registerInfo('Test');
		$this->factory->registerInfo('Test');
		$blueScreen = $this->factory->create();

		$this->assertInstanceOf(BlueScreen::class, $blueScreen);
		$this->assertCount(1, array_filter($blueScreen->info, function ($item) {
			return $item === 'Test';
		}));
	}

	/**
	 * @expectedException \Nella\MonologTracy\Tracy\PanelIsNotCallableException
	 */
	public function testRegisterInvalidPanel()
	{
		$this->factory->registerPanel(NULL);
	}

	public function testRegisterPanel()
	{
		$this->factory->registerPanel(function ($exception) {
			return [
				'tab' => 'Test',
				'panel' => 'Test',
			];
		});

		$this->assertTrue(TRUE);
	}

	public function testRegisterPanelMultiple()
	{
		$panel = function ($exception) {
			return [
				'tab' => 'Test',
				'panel' => 'Test',
			];
		};

		$this->factory->registerPanel($panel);
		$this->factory->registerPanel($panel);

		$this->assertTrue(TRUE);
	}

	public function testCreate()
	{
		$blueScreen = $this->factory->create();

		$this->assertInstanceOf(BlueScreen::class, $blueScreen);
	}

}
