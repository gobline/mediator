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
        $this->addListener($subscriber, $subscriber->getSubscribedEvents());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addListener($listener, array $events)
    {
        if (!is_object($listener)) {
            throw new \InvalidArgumentException('$listener must be an object or closure');
        }

        foreach ($events as $eventName => $eventMethodName) {
            $eventName = (string) $eventName;
            if ($eventName === '') {
                throw new \InvalidArgumentException('$events cannot contain empty event names');
            }

            $eventMethodName = (string) $eventMethodName;
            if ($eventMethodName === '') {
                throw new \InvalidArgumentException('$events cannot contain empty event method names');
            }

            $this->listeners[$eventName][] = [$listener, $eventMethodName];
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($event, array $data = [])
    {
        $event = (string) $event;
        if ($event === '') {
            throw new \InvalidArgumentException('$event cannot be empty');
        }

        if (!isset($this->listeners[$event])) {
            return;
        }

        foreach ($this->listeners[$event] as $callback) {
            list($listener, $methodName) = $callback;

            if ($listener instanceof \Closure) {
                $listener = $listener();
            }

            if (!method_exists($listener, $methodName)) {
                throw new \RuntimeException(
                    'Method '.$methodName.' doesn\'t exist in the listener class '.get_class($listener));
            }

            $listener->$methodName($data);
        }
    }
}
