<?php

/**
 * germania-kg/update-command
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests;

use Laminas\Log\PsrLoggerAdapter;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    use LoggerAwareTrait;

    /**
     * @var int
     */
    public $loglevel = \Laminas\Log\Logger::ALERT;

    protected function getLogger(): LoggerInterface
    {
        if ($this->logger) {
            return $this->logger;
        }

        $this->setLogger($this->createLaminasLogger());

        return $this->logger;
    }

    protected function createLaminasLogger(): PsrLoggerAdapter
    {
        $loglevel = ($GLOBALS['LAMINAS_LOGLEVEL'] ?? $this->loglevel) ?: $this->loglevel;
        $filter = new \Laminas\Log\Filter\Priority($loglevel);

        $writer = new \Laminas\Log\Writer\Stream('php://output');
        $writer->addFilter($filter);

        $laminasLogLogger = new \Laminas\Log\Logger();
        $laminasLogLogger->addWriter($writer);

        return new \Laminas\Log\PsrLoggerAdapter($laminasLogLogger);
    }
}
