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
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class EventDispatcher implements EventDispatcherInterface
{
    private $listeners = [];

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->addListener($subscriber->getSubscribedEvents(), $subscriber);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addListener($events, $listener)
    {
        if (!is_array($events)) {
            $events = [$events];
        }

        if (!is_object($listener)) {
            throw new \InvalidArgumentException('$listener must be an object or closure');
        }

        foreach ($events as $event) {
            $event = (string) $event;
            if ($event === '') {
                throw new \InvalidArgumentException('$event cannot be empty');
            }

            $this->listeners[$event][] = $listener;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($event)
    {
        $event = (string) $event;
        if ($event === '') {
            throw new \InvalidArgumentException('$event cannot be empty');
        }

        if (!isset($this->listeners[$event])) {
            return;
        }

        $method = $this->getEventMethodName($event);

        foreach ($this->listeners[$event] as &$listener) {
            if ($listener instanceof \Closure) {
                $listener = $listener();
            }

            if (!method_exists($listener, $method)) {
                throw new \RuntimeException(
                    'Method '.$method.' doesn\'t exist in the listener class '.get_class($listener));
            }

            $listener->$method();
        }
    }

    private function getEventMethodName($event)
    {
        return 'on'.ucfirst($event);
    }
}
