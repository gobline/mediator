<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Mediator;

/**
 * Allows components to communicate with each other by dispatching events and listening to them.
 *
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
interface EventDispatcherInterface
{
    /**
     * @param EventSubscriberInterface $subscriber
     *
     * @throws \InvalidArgumentException
     *
     * @return EventDispatcherInterface
     */
    public function addSubscriber(EventSubscriberInterface $subscriber);

    /**
     * @param string $event
     *
     * @throws \InvalidArgumentException
     */
    public function dispatch($event);
}
