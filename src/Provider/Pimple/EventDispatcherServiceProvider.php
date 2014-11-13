<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Mediator\Provider\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Mendo\Mediator\EventDispatcher;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class EventDispatcherServiceProvider implements ServiceProviderInterface
{
    private $reference;

    public function __construct($reference = 'eventDispatcher')
    {
        $this->reference = $reference;
    }

    public function register(Container $container)
    {
        $container[$this->reference] = function ($c) {
            return new EventDispatcher();
        };
    }
}
