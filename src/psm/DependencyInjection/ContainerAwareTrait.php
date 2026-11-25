<?php

/**
 * PHP Server Monitor
 *
 * Replacement for Symfony\Component\DependencyInjection\ContainerAwareTrait,
 * which was removed in Symfony 7.
 *
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

trait ContainerAwareTrait
{
    /**
     * @var ContainerInterface|null
     */
    protected $container;

    public function setContainer(?ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
