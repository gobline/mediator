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
        return ['fooEvent'];
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
$dispatcher->addListener('fooEvent', $listener);
```

### Adding Closures

Adding a closure allows you to lazy load the listener instance.

```php
$dispatcher->addListener('fooEvent', function() {
	return new FooListener();
});
```

### Dispatching Events

```php
$dispatcher->dispatch('fooEvent');
```
