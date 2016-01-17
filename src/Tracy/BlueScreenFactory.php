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

use Tracy\BlueScreen;
use Tracy\Debugger;

class BlueScreenFactory
{

	/** @var string[] */
	private $info = [];

	/** @var callable[] */
	private $panels = [];

	/** @var string[] */
	private $collapsePaths = [];

	public function __construct()
	{
		$this->registerInfo('PHP ' . PHP_VERSION);
		if (isset($_SERVER['SERVER_SOFTWARE'])) {
			$this->registerInfo($_SERVER['SERVER_SOFTWARE']);
		}
		$this->registerInfo('Tracy ' . Debugger::VERSION);
	}

	/**
	 * @param string $text
	 */
	public function registerInfo($text)
	{
		if (!is_string($text)) {
			throw new \Nella\MonologTracy\Tracy\InfoMustBeStringException(gettype($text));
		}
		if (in_array($text, $this->info, TRUE)) {
			return;
		}

		$this->info[] = $text;
	}

	/**
	 * @param callable $callback
	 */
	public function registerPanel($callback)
	{
		if (in_array($callback, $this->panels, TRUE)) {
			return;
		}
		if (!is_callable($callback, TRUE)) {
			throw new \Nella\MonologTracy\Tracy\PanelIsNotCallableException();
		}

		$this->panels[] = $callback;
	}

	public function registerCollapsePath($collapsePath)
	{
		if (!is_string($collapsePath)) {
			throw new \Nella\MonologTracy\Tracy\CollapsePathMustBeStringException(gettype($collapsePath));
		}

		$this->collapsePaths[] = $collapsePath;
	}

	/**
	 * @return BlueScreen
	 */
	public function create()
	{
		$blueScreen = new BlueScreen();
		$blueScreen->info = $this->info;
		foreach ($this->panels as $panel) {
			$blueScreen->addPanel($panel);
		}
		$blueScreen->collapsePaths = $this->collapsePaths;

		return $blueScreen;
	}

}
