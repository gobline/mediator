<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mendo\Mediator\EventDispatcher;
use Mendo\Mediator\EventSubscriberInterface;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class EventDispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testEventListener()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addListener('fooEvent', new FooListener());

        $this->expectOutputString('hello world');
        $dispatcher->dispatch('fooEvent');

        $this->assertTrue(true);
    }

    public function testEventSubscriber()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addSubscriber(new FooListener());

        $this->expectOutputString('hello world');
        $dispatcher->dispatch('fooEvent');

        $this->assertTrue(true);
    }

    public function testClosureListener()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addListener('fooEvent', function () {
            return new FooListener();
        });

        $this->expectOutputString('hello world');
        $dispatcher->dispatch('fooEvent');

        $this->assertTrue(true);
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
    public function onFooEvent()
    {
        echo 'hello world';
    }

    public function getSubscribedEvents()
    {
        return ['fooEvent'];
    }
}
