<?php

/**
 * PHP Server Monitor
 *
 * Replacement for Symfony\Component\DependencyInjection\ContainerAwareInterface,
 * which was removed in Symfony 7.
 *
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

interface ContainerAwareInterface
{
    /**
     * Sets the container.
     */
    public function setContainer(?ContainerInterface $container = null);
}
