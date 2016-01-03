<?php
/**
 * This file is part of the Nella Project (https://monolog-tracy.nella.io).
 *
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 * Copyright (c) Patrik Votoček (http://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\MonologTracy;

use Monolog\Logger;
use Tracy\BlueScreen;

class BlueScreenHandler extends \Monolog\Handler\AbstractProcessingHandler
{

	/** @var LoggerHelper */
	private $loggerHelper;

	/**
	 * @param BlueScreen $blueScreen
	 * @param bool $logDirectory
	 * @param int $level
	 * @param bool $bubble
	 */
	public function __construct(BlueScreen $blueScreen, $logDirectory, $level = Logger::DEBUG, $bubble = TRUE)
	{
		parent::__construct($level, $bubble);

		$this->loggerHelper = new LoggerHelper($logDirectory, $blueScreen);
	}

	/**
	 * @param array $record
	 */
	protected function write(array $record)
	{
		if (!isset($record['context']['exception']) || (!$record['context']['exception'] instanceof \Exception
			&& !$record['context']['exception'] instanceof \Throwable
		)) {
			return;
		}
		$exception = $record['context']['exception'];

		if (!file_exists($this->loggerHelper->getExceptionFile($exception))) {
			$this->loggerHelper->renderToFile($exception);
		}
	}

}
