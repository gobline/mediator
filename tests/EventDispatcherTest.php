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
    public function testDispatchEvent()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addSubscriber(new FooSubscriber());

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

class FooSubscriber implements EventSubscriberInterface
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
