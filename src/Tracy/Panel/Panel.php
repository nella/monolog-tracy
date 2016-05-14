<?php
/**
 * This file is part of the Nella Project (https://monolog-tracy.nella.io).
 *
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\MonologTracy\Tracy\Panel;

abstract class Panel
{

	/**
	 * @param \Exception|\Throwable $exception
	 * @return bool
	 */
	abstract public function isSupported($exception);

	/**
	 * @param \Exception|\Throwable $exception
	 * @return string
	 */
	abstract public function getTab($exception);

	/**
	 * @param \Exception|\Throwable $exception
	 * @return string
	 */
	abstract public function getPanel($exception);

	/**
	 * @param \Exception|\Throwable $exception
	 * @return string[]
	 */
	final public function __invoke($exception)
	{
		if (!$this->isSupported($exception)) {
			return [];
		}

		return [
			'tab' => $this->getTab($exception),
			'panel' => $this->getPanel($exception),
		];
	}

}
