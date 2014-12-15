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
    private $subscribers = [];

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $event) {
            $event = (string) $event;
            if ($event === '') {
                throw new \InvalidArgumentException('$event cannot be empty');
            }
            $this->subscribers[$event][] = $subscriber;
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
        if (!isset($this->subscribers[$event])) {
            return;
        }
        $method = 'on'.ucfirst($event);
        foreach ($this->subscribers[$event] as $subscriber) {
            $subscriber->$method();
        }
    }
}
