<?php

/*
 * Gobline Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Gobline\Mediator\EventDispatcher;
use Gobline\Mediator\EventSubscriberInterface;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class EventDispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testEventListener()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addListener(
            new FooListener(),
            [
                'fooEvent' => 'onFooEvent'
            ]);

        $this->expectOutputString('hello world');
        $dispatcher->dispatch('fooEvent', ['qux' => 'corge']);
    }

    public function testEventSubscriber()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addSubscriber(new FooListener());

        $this->expectOutputString('hello world');
        $dispatcher->dispatch('fooEvent', ['qux' => 'corge']);
    }

    public function testClosureListener()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addListener(
            function () { return new FooListener(); },
            [
                'fooEvent' => 'onFooEvent'
            ]);

        $this->expectOutputString('hello world');
        $dispatcher->dispatch('fooEvent', ['qux' => 'corge']);
    }

    public function testDispatchEmptyEvent()
    {
        $dispatcher = new EventDispatcher();
        $this->setExpectedException('\InvalidArgumentException', 'empty');
        $dispatcher->dispatch('');
    }
}

class FooListener implements EventSubscriberInterface
{
    public function onFooEvent(array $data)
    {
        if (!isset($data['qux'])) {
            throw new \Exception('Expected qux parameter not found');
        }

        echo 'hello world';
    }

    public function getSubscribedEvents()
    {
        return ['fooEvent' => 'onFooEvent'];
    }
}
