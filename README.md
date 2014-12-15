# Mediator Component - Mendo Framework

The Mendo Mediator component allows your application components to communicate with each other by dispatching events and listening to them. It implements the mediator behavioral design pattern.

### Creating the Dispatcher

```php
use Mendo\Mediator\EventDispatcher;

$dispatcher = new EventDispatcher();
```

### Adding Event Subscribers

```php
use Mendo\Mediator\EventSubscriberInterface;

class FooSubscriber implements EventSubscriberInterface
{
    public function onFooEvent()
    {
        // ... do something
    }

    public function getSubscribedEvents()
    {
        return ['fooEvent' => 'onFooEvent'];
    }
}

$subscriber = new FooSubscriber();
$dispatcher->addSubscriber($subscriber);
```

### Adding Event Listeners

Event listeners are similar to event subscribers. 
The only difference is that an event listener doesn't need to implement the *EventSubscriberInterface* interface
and provide the events it listens to. Instead, you specify the events it listens to outside the class.
The equivalent of the sample above using an event listener would be:

```php
class FooListener
{
    public function onFooEvent()
    {
        // ... do something
    }
}

$listener = new FooListener();
$dispatcher->addListener($listener, ['fooEvent' => 'onFooEvent']);
```

### Lazy Listeners

You can add a closure which will lazy load the listener instance.
This allows the listener to be instantiated only when an event it listens to is dispatched.

```php
$dispatcher->addListener(
    function() { return new FooListener(); },
    ['fooEvent' => 'onFooEvent']);
```

### Dispatching Events

```php
$dispatcher->dispatch('fooEvent');
```

## Passing event data

```php
$dispatcher->dispatch('fooEvent', ['foo' => 'bar']);

class FooListener
{
    public function onFooEvent(array $data)
    {
        // ... do something with $data['foo']
    }
}
```

## Installation

You can install Mendo Mediator using the dependency management tool [Composer](https://getcomposer.org/).
Run the *require* command to resolve and download the dependencies:

```
composer require mendoframework/mediator
```