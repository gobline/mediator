<?php

/*
 * Gobline Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Mediator;

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
     * @param object $listener
     * @param array  $events
     *
     * @throws \InvalidArgumentException
     *
     * @return EventDispatcherInterface
     */
    public function addListener($listener, array $events);

    /**
     * @param string $event
     * @param array  $data
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function dispatch($event, array $data = []);
}
